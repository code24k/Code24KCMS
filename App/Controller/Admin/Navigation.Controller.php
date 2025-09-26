<?php
namespace App\Controller\Admin;

use App\Model\GlobalSettingModel;
use App\Model\NavigationModel;
use XHB2\View;
use XHB2\Response;

use function XHB2\DD;
use function XHB2\Translate;

class NavigationController {

    /**
     * 
     * 导航列表
     */
    public function List(\XHB2\Request $request) {
        $NavigationModel = new NavigationModel();
        View::Make("Admin/Navigation/List", [
            "request" => $request,
            "urlParams" => $request->GetParseUrlParams(),
            "listData" => $NavigationModel->List($request)
        ]);
    }

    /**
     * 新增导航
     */
    public function Add(\XHB2\Request $request) {
        if($request->GetRequestMethod() == "POST"){
            $NavigationModel = new NavigationModel();
            return Response::Output($NavigationModel->Add($request));
        }
        View::Make("Admin/Navigation/Add", [
            "request" => $request
        ]);
    }

    /**
     * 编辑导航
     */
    public function Edit(\XHB2\Request $request) {
        if($request->GetRequestMethod() == "POST"){
            $NavigationModel = new NavigationModel();
            return Response::Output($NavigationModel->Edit($request));
        }
        $id = $request->GetParseUrlParamIndex(4);
        $NavigationModel = new NavigationModel();
        $detail = $NavigationModel->GetDetail($request, $id);
        View::Make("Admin/Navigation/Edit", [
            "request" => $request,
            "detail" => $detail,
        ]);
    }

    /**
     * 删除导航
     */
    public function Delete(\XHB2\Request $request) {
        if($request->GetRequestMethod() == "POST"){
            $NavigationModel = new NavigationModel();
            return Response::Output($NavigationModel->Delete($request));
        }
        $id = $request->GetParseUrlParamIndex(4);
        $NavigationModel = new NavigationModel();
        $detail = $NavigationModel->GetDetail($request, $id);
        View::Make("Admin/Navigation/Delete", [
            "request" => $request,
            "detail" => $detail,
        ]);
    }

}
?>