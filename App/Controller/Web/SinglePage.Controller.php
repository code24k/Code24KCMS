<?php
namespace App\Controller\Web;

use App\Model\ArticleModel;
use App\Model\ProductModel;
use App\Model\SinglePageModel;
use XHB2\View;
use XHB2\Response;

use function XHB2\DD;

class SinglePageController extends BaseController{
    /**
     * 单页详情
     */
    public function Detail(\XHB2\Request $request) {
        $paramId = $request->GetParseUrlParamIndex(4);
        if(empty($paramId)){
            View::Make("Web/Error/404", []);
            return;
        }
        $singlePageModel = new SinglePageModel();
        $detail = $singlePageModel->GetDetail($request, $paramId);
        if(!is_array($detail) || count($detail) == 0){
            View::Make("Web/Error/404", []);
            return;
        }
        $response = \XHB2\Response::Instance();
        $response->SetSeoTitle($detail["Title"]);
        $response->SetSeoKeywords($detail["Keywords"]);
        $response->SetSeoDescription($detail["Description"]);

        $articleModel = new ArticleModel();
        View::Make("Web/SinglePage/Detail", [
            "request" => $request,
            "detail" => $detail,
            "articleListNew10" => $articleModel->ArticleListNew10($request),
        ]);
    }


}
?>