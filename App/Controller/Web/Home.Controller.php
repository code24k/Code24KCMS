<?php
namespace App\Controller\Web;

use App\Model\GlobalSettingModel;
use App\Model\ProductModel;
use XHB2\View;
use XHB2\Response;

use function XHB2\DD;

class HomeController extends BaseController{
    /**
     * 网站首页
     */
    public function Index(\XHB2\Request $request) {
        $globalSettingModel = new GlobalSettingModel();
        $getBaseSetting = $globalSettingModel->GetBaseSetting($request);
        $response = \XHB2\Response::Instance();
        $response->SetSeoTitle(array_key_exists("", $getBaseSetting) ? $getBaseSetting["WebsiteName"] : "");
        $response->SetSeoKeywords(array_key_exists("", $getBaseSetting) ? $getBaseSetting["WebsiteKeywords"] : "");
        $response->SetSeoDescription(array_key_exists("", $getBaseSetting) ? $getBaseSetting["WebsiteDescription"] : "");
        $productModel = new ProductModel();
        View::Make("Web/Home/Index", [
            "request" => $request,
            "productListNew15" => $productModel->ProductListNew15($request),
        ]);
    }


}
?>