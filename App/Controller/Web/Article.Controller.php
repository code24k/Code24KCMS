<?php
namespace App\Controller\Web;

use App\Model\ArticleCategoryModel;
use App\Model\ArticleModel;
use XHB2\View;
use XHB2\Response;

use function XHB2\DD;

class ArticleController extends BaseController{
    /**
     * 文章首页
     */
    public function Index(\XHB2\Request $request) {
        $globalSettingModel = new \App\Model\GlobalSettingModel();
        $getBaseSetting = $globalSettingModel->GetBaseSetting($request);
        if(is_array($getBaseSetting) && array_key_exists("WebsiteName", $getBaseSetting)){
            $response = \XHB2\Response::Instance();
            $response->SetSeoTitle($getBaseSetting["WebsiteName"]);
            $response->SetSeoKeywords($getBaseSetting["WebsiteKeywords"]);
            $response->SetSeoDescription($getBaseSetting["WebsiteDescription"]);
        }
        $articleCategoryModel = new ArticleCategoryModel();
        $articleModel = new ArticleModel();
        View::Make("Web/Article/Index", [                  
            "request" => $request,
            "listData" => $articleModel->List($request),
            "getListArray" => $articleCategoryModel->GetListArray($request),
            "articleListNew10" => $articleModel->ArticleListNew10($request),
        ]);
    }

    /**
     * 文章详情
     */
    public function Detail(\XHB2\Request $request) {
        $paramId = $request->GetParseUrlParamIndex(4);
        if(empty($paramId)){
            View::Make("Web/Error/404", []);
            return;
        }
        $articleModel = new ArticleModel();
        $detail = $articleModel->GetDetail($request, $paramId);
        if(!is_array($detail) || count($detail) == 0){
            View::Make("Web/Error/404", []);
            return;
        }
        $response = \XHB2\Response::Instance();
        $response->SetSeoTitle($detail["Title"]);
        $response->SetSeoKeywords($detail["Keywords"]);
        $response->SetSeoDescription($detail["Description"]);
        $articleModel = new ArticleModel();
        View::Make("Web/Article/Detail", [
            "request" => $request,
            "detail" => $detail,
            "articleListNew10" => $articleModel->ArticleListNew10($request),
        ]);
    }

}
?>