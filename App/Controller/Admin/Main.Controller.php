<?php
namespace App\Controller\Admin;

use App\Model\LoginModel;
use XHB2\View;
use XHB2\Response;

use function XHB2\DD;
use function XHB2\Translate;

class MainController {

    /**
     * 
     * 后台管理中心
     */
    public function Index(\XHB2\Request $request) {
        $administratorManagementCenter = Translate($request->GetTranslate(), "AdministratorManagementCenter");
        Response::Instance()->SetSeoTitle($administratorManagementCenter);
        View::Make("Admin/Main/Index", [
            "request" => $request
        ]);
    }

    /**
     * 后台管理默认首页
     */
    public function Main(\XHB2\Request $request) {
        View::Make("Admin/Main/Main", [
            "request" => $request
        ]);
    }
}
?>