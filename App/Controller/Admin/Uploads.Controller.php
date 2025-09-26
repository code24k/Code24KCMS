<?php
namespace App\Controller\Admin;

/**
 * UEEditor服务器统一请求接口
 * 处理所有UEEditor的请求，包括配置获取、文件上传等
 * 
 * 当出现 "413 Request Entity Too Large" 错误时，意味着客户端上传的文件大小超过了服务器的限制。要解决这个问题，需要调整服务器和相关配置中的文件大小限制。
 * 1. 修改 PHP 配置（php.ini）
 * 上传文件的最大大小
 * upload_max_filesize = 20M
 * POST 数据的最大大小（应大于或等于 upload_max_filesize）
 * post_max_size = 20M
 * PHP 脚本执行时间（可选，防止大文件上传超时）
 * max_execution_time = 300
 * 2. 调整 Nginx 配置（如果使用 Nginx）
 * http {
 *     # ... 其他配置
 *     client_max_body_size 20M;  # 设置为所需的最大文件大小
 *     # ... 其他配置
 * }
 * 修改后重启 Nginx
 * sudo service nginx restart
 * 3. 调整 Apache 配置（如果使用 Apache）
 * # .htaccess 文件
 * php_value upload_max_filesize 20M
 * php_value post_max_size 20M
 * php_value max_execution_time 300
 * 或者在 httpd.conf 中
 * LimitRequestBody 20971520  # 20MB (20 * 1024 * 1024)
 */

class UploadsController {

    // 定义上传文件保存路径（请确保目录存在且有写入权限）
    private $UPLOAD_PATH;
    // 定义访问上传文件的URL前缀
    private $UPLOAD_URL;

    // 允许的文件类型
    private $allowTypes = [
        'image' => ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/bmp'],
        'file'  => ['application/msword', 'application/vnd.ms-excel', 'application/vnd.ms-powerpoint', 
                    'application/pdf', 'text/plain', 'application/zip', 'application/rar']
    ];

    // 最大文件大小(字节)
    private $maxSize = [
        'image' => 20 * 1024 * 1024, // 20MB
        'file'  => 100 * 1024 * 1024 // 100MB
    ];

    public function __construct() {
        $this->UPLOAD_PATH = \XHB2\PublicPath(). "/Uploads/";
        $this->UPLOAD_URL = "/Uploads/";
    }

    public function Upload(){
        // 获取请求动作
        $action = isset($_GET['action']) ? $_GET['action'] : '';           

        // 根据不同动作处理请求
        switch ($action) {
            case 'config':
                // 返回编辑器配置
                $result = $this->GetConfig($this->allowTypes, $this->maxSize);
                break;
                
            case 'uploadimage':
                // 处理图片上传
                $result = $this->UploadFile('upfile', 'image', $this->allowTypes['image'], $this->maxSize['image']);
                break;
                
            case 'uploadfile':
                // 处理普通文件上传
                $result = $this->UploadFile('upfile', 'file', $this->allowTypes['file'], $this->maxSize['file']);
                break;
                
            // 可以根据需要添加其他动作的处理，如涂鸦上传、视频上传等
            default:
                $result = [
                    'state' => '请求地址错误'
                ];
                break;
        }

        // 输出结果
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($result);
    }

    /**
     * 获取编辑器配置
     */
    public function GetConfig($allowTypes, $maxSize) {
        return [
            "imageActionName" => "uploadimage",
            "imageFieldName" => "upfile",
            "imageMaxSize" => $maxSize['image'],
            "imageAllowFiles" => array_map(function($type) {
                return '.' . preg_split('#[/+]#', $type)[1];
            }, $allowTypes['image']),
            "imageCompressEnable" => true,
            "imageCompressBorder" => 1600,
            "imageInsertAlign" => "none",
            "imageUrlPrefix" => "",
            "imagePathFormat" => "/Uploads/Image/{yyyy}{mm}{dd}/{time}{rand:6}",
            
            "fileActionName" => "uploadfile",
            "fileFieldName" => "upfile",
            "fileMaxSize" => $maxSize['file'],
            "fileAllowFiles" => array_map(function($type) {
                $ext = preg_split('#[/+]#', $type)[1];
                return '.' . ($ext == 'vnd.ms-excel' ? 'xls' : $ext);
            }, $allowTypes['file']),
            "fileUrlPrefix" => "",
            "filePathFormat" => "/Uploads/File/{yyyy}{mm}{dd}/{time}{rand:6}"
        ];
    }

    /**
     * 处理文件上传
     * @param string $field 表单字段名
     * @param string $type 文件类型(image/file等)
     * @param array $allowTypes 允许的MIME类型
     * @param int $maxSize 最大文件大小
     * @return array 上传结果
     */
    public function UploadFile($field, $type, $allowTypes, $maxSize) {
        // 检查是否有文件上传
        if (!isset($_FILES[$field])) {
            return ['state' => '未找到上传文件'];
        }
        
        $file = $_FILES[$field];
        
        // 检查上传错误
        if ($file['error'] != UPLOAD_ERR_OK) {
            return ['state' => $this->GetUploadErrorMsg($file['error'])];
        }
        
        // 检查文件类型
        if (!in_array($file['type'], $allowTypes)) {
            print_r($file['type']);
            exit();
            return ['state' => '不允许的文件类型: ' . $file['type']];
        }
        
        // 检查文件大小
        if ($file['size'] > $maxSize) {
            return ['state' => '文件大小超过限制，最大允许' . $this->FormatSize($maxSize)];
        }
        
        // 创建保存目录
        $saveDir = $this->UPLOAD_PATH . ucfirst($type) . '/' . date('Ymd') . '/';
        if (!is_dir($saveDir) && !mkdir($saveDir, 0755, true)) {
            return ['state' => '无法创建保存目录'];
        }
        
        // 生成文件名
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = date('His') . '_' . rand(100000, 999999) . '.' . $ext;
        $savePath = $saveDir . $fileName;
        
        // 移动上传文件
        if (!move_uploaded_file($file['tmp_name'], $savePath)) {
            return ['state' => '文件上传失败'];
        }
        
        // 返回成功结果
        $fileUrl = $this->UPLOAD_URL . ucfirst($type) . '/' . date('Ymd') . '/' . $fileName;
        // $fileUrl = 'php/uploads/' . $type . '/' . date('Ymd') . '/' . $fileName;
        return [
            'state' => 'SUCCESS',
            'url' => $fileUrl,
            'title' => $fileName,
            'original' => $file['name'],
            'type' => '.' . $ext,
            'size' => $file['size']
        ];
    }

    /**
     * 获取上传错误信息
     * @param int $errorCode 错误代码
     * @return string 错误信息
     */
    public function GetUploadErrorMsg($errorCode) {
        $errors = [
            UPLOAD_ERR_INI_SIZE => '上传文件超过了php.ini中的限制',
            UPLOAD_ERR_FORM_SIZE => '上传文件超过了表单中的限制',
            UPLOAD_ERR_PARTIAL => '文件仅部分被上传',
            UPLOAD_ERR_NO_FILE => '没有文件被上传',
            UPLOAD_ERR_NO_TMP_DIR => '缺少临时文件夹',
            UPLOAD_ERR_CANT_WRITE => '文件写入失败',
            UPLOAD_ERR_EXTENSION => '文件上传被扩展阻止'
        ];
        return isset($errors[$errorCode]) ? $errors[$errorCode] : '未知上传错误: ' . $errorCode;
    }

    /**
     * 格式化文件大小
     * @param int $size 字节数
     * @return string 格式化后的大小
     */
    public function FormatSize($size) {
        $units = ['B', 'KB', 'MB', 'GB'];
        $unit = 0;
        while ($size >= 1024 && $unit < 3) {
            $size /= 1024;
            $unit++;
        }
        return round($size, 2) . $units[$unit];
    }

    public function __destruct()
    {
        
    }
}
?>