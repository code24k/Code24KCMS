<?php
namespace App\Controller\Web;

use App\Model\ProductCategoryModel;
use App\Model\ProductModel;
use XHB2\View;
use XHB2\Response;

use function XHB2\DD;

class ProductController extends BaseController{
    /**
     * 产品首页
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
        $productCategoryModel = new ProductCategoryModel();
        $productModel = new ProductModel();
        View::Make("Web/Product/Index", [                  
            "request" => $request,
            "listData" => $productModel->List($request),
            "getListArray" => $productCategoryModel->GetListArray($request)
        ]);
    }

    /**
     * 产品详情
     */
    public function Detail(\XHB2\Request $request) {
        $paramId = $request->GetParseUrlParamIndex(4);
        if(empty($paramId)){
            View::Make("Web/Error/404", []);
            return;
        }
        $ProductModel = new ProductModel();
        $detail = $ProductModel->GetDetail($request, $paramId);
        if(!is_array($detail) || count($detail) == 0){
            View::Make("Web/Error/404", []);
            return;
        }
        $response = \XHB2\Response::Instance();
        $response->SetSeoTitle($detail["Title"]);
        $response->SetSeoKeywords($detail["Keywords"]);
        $response->SetSeoDescription($detail["Description"]);
        $productCategoryModel = new ProductCategoryModel();
        $ProductModel = new ProductModel();
        View::Make("Web/Product/Detail", [
            "request" => $request,
            "detail" => $detail,
            "getListArray" => $productCategoryModel->GetListArray($request)
        ]);
    }

}
?>