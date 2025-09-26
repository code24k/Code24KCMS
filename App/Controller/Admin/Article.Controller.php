<?php
namespace App\Controller\Admin;

use App\Model\ArticleCategoryModel;
use App\Model\GlobalSettingModel;
use App\Model\ArticleModel;
use XHB2\View;
use XHB2\Response;

use function XHB2\DD;
use function XHB2\Translate;

class ArticleController {

    /**
     * 
     * 文章列表
     */
    public function List(\XHB2\Request $request) {
        $articleModel = new ArticleModel();
        View::Make("Admin/Article/List", [
            "request" => $request,
            "urlParams" => $request->GetParseUrlParams(),
            "listData" => $articleModel->List($request)
        ]);
    }

    /**
     * 新增文章
     */
    public function Add(\XHB2\Request $request) {
        if($request->GetRequestMethod() == "POST"){
            $articleModel = new ArticleModel();
            return Response::Output($articleModel->Add($request));
        }
        $articleCategoryModel = new ArticleCategoryModel();
        View::Make("Admin/Article/Add", [
            "request" => $request,
            "getListArray" => $articleCategoryModel->GetListArray($request)
        ]);
    }

    /**
     * 编辑文章
     */
    public function Edit(\XHB2\Request $request) {
        if($request->GetRequestMethod() == "POST"){
            $articleModel = new ArticleModel();
            return Response::Output($articleModel->Edit($request));
        }
        $id = $request->GetParseUrlParamIndex(4);
        $articleCategoryModel = new ArticleCategoryModel();
        $articleModel = new ArticleModel();
        $detail = $articleModel->GetDetail($request, $id);
        View::Make("Admin/Article/Edit", [
            "request" => $request,
            "detail" => $detail,
            "getListArray" => $articleCategoryModel->GetListArray($request)
        ]);
    }

    /**
     * 删除文章
     */
    public function Delete(\XHB2\Request $request) {
        if($request->GetRequestMethod() == "POST"){
            $articleModel = new ArticleModel();
            return Response::Output($articleModel->Delete($request));
        }
        $id = $request->GetParseUrlParamIndex(4);
        $articleModel = new ArticleModel();
        $detail = $articleModel->GetDetail($request, $id);
        View::Make("Admin/Article/Delete", [
            "request" => $request,
            "detail" => $detail,
        ]);
    }

}
?>