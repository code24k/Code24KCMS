<?php
namespace App\Controller\Admin;

use App\Model\GlobalSettingModel;
use App\Model\ArticleCategoryModel;
use XHB2\View;
use XHB2\Response;

use function XHB2\DD;
use function XHB2\Translate;

class ArticleCategoryController {

    /**
     * 
     * 类别列表
     */
    public function List(\XHB2\Request $request) {
        $articleCategoryModel = new ArticleCategoryModel();
        View::Make("Admin/ArticleCategory/List", [
            "request" => $request,
            "urlParams" => $request->GetParseUrlParams(),
            "listData" => $articleCategoryModel->List($request)
        ]);
    }

    /**
     * 新增类别
     */
    public function Add(\XHB2\Request $request) {
        if($request->GetRequestMethod() == "POST"){
            $articleCategoryModel = new ArticleCategoryModel();
            return Response::Output($articleCategoryModel->Add($request));
        }
        View::Make("Admin/ArticleCategory/Add", [
            "request" => $request
        ]);
    }

    /**
     * 编辑类别
     */
    public function Edit(\XHB2\Request $request) {
        if($request->GetRequestMethod() == "POST"){
            $articleCategoryModel = new ArticleCategoryModel();
            return Response::Output($articleCategoryModel->Edit($request));
        }
        $id = $request->GetParseUrlParamIndex(4);
        $articleCategoryModel = new ArticleCategoryModel();
        $detail = $articleCategoryModel->GetDetail($request, $id);
        View::Make("Admin/ArticleCategory/Edit", [
            "request" => $request,
            "detail" => $detail,
        ]);
    }

    /**
     * 删除类别
     */
    public function Delete(\XHB2\Request $request) {
        if($request->GetRequestMethod() == "POST"){
            $articleCategoryModel = new ArticleCategoryModel();
            return Response::Output($articleCategoryModel->Delete($request));
        }
        $id = $request->GetParseUrlParamIndex(4);
        $articleCategoryModel = new ArticleCategoryModel();
        $detail = $articleCategoryModel->GetDetail($request, $id);
        View::Make("Admin/ArticleCategory/Delete", [
            "request" => $request,
            "detail" => $detail,
        ]);
    }

    /**
     * Obtain the detailed information of the global Settings
     * 获取类别详情
     */
    public function GetDetail(\XHB2\Request $request) {
        // $articleCategoryModel = new ArticleCategoryModel();
        // return Response::Output($articleCategoryModel->GetDetail($request));
    }

}
?>