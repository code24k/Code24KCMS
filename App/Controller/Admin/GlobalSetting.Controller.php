<?php
namespace App\Controller\Admin;

use App\Model\GlobalSettingModel;
use XHB2\View;
use XHB2\Response;

use function XHB2\DD;
use function XHB2\Translate;

class GlobalSettingController {

    /**
     * Basic setup
     * 基础设置
     */
    public function BaseSetting(\XHB2\Request $request) {
        if($request->GetRequestMethod() == "POST"){
            $globalSettingModel = new GlobalSettingModel();
            return Response::Output($globalSettingModel->SetBaseSetting($request));
        }
        View::Make("Admin/GlobalSetting/BaseSetting", [
            "request" => $request
        ]);
    }

    /**
     * Obtain the detailed information of the global Settings
     * 获取全局设置详情信息
     */
    public function GetDetail(\XHB2\Request $request) {
        $globalSettingModel = new GlobalSettingModel();
        return Response::Output($globalSettingModel->GetDetail($request));
    }

}
?>