<?php
namespace App\Controller\Admin;

use App\Model\GlobalSettingModel;
use App\Model\SinglePageModel;
use XHB2\View;
use XHB2\Response;

use function XHB2\DD;
use function XHB2\Translate;

class SinglePageController {

    /**
     * 
     * 单页列表
     */
    public function List(\XHB2\Request $request) {
        $singlePageModel = new SinglePageModel();
        View::Make("Admin/SinglePage/List", [
            "request" => $request,
            "urlParams" => $request->GetParseUrlParams(),
            "listData" => $singlePageModel->List($request)
        ]);
    }

    /**
     * 新增单页
     */
    public function Add(\XHB2\Request $request) {
        if($request->GetRequestMethod() == "POST"){
            $singlePageModel = new SinglePageModel();
            return Response::Output($singlePageModel->Add($request));
        }
        View::Make("Admin/SinglePage/Add", [
            "request" => $request
        ]);
    }

    /**
     * 编辑单页
     */
    public function Edit(\XHB2\Request $request) {
        if($request->GetRequestMethod() == "POST"){
            $singlePageModel = new SinglePageModel();
            return Response::Output($singlePageModel->Edit($request));
        }
        $id = $request->GetParseUrlParamIndex(4);
        $singlePageModel = new singlePageModel();
        $detail = $singlePageModel->GetDetail($request, $id);
        View::Make("Admin/SinglePage/Edit", [
            "request" => $request,
            "detail" => $detail,
        ]);
    }

    /**
     * 删除单页
     */
    public function Delete(\XHB2\Request $request) {
        if($request->GetRequestMethod() == "POST"){
            $singlePageModel = new SinglePageModel();
            return Response::Output($singlePageModel->Delete($request));
        }
        $id = $request->GetParseUrlParamIndex(4);
        $singlePageModel = new singlePageModel();
        $detail = $singlePageModel->GetDetail($request, $id);
        View::Make("Admin/SinglePage/Delete", [
            "request" => $request,
            "detail" => $detail,
        ]);
    }

}
?>