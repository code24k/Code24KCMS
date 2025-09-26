<?php
namespace App\Controller\Admin;

use App\Model\LoginModel;
use XHB2\View;
use XHB2\Response;

use function XHB2\DD;

class LoginController {

    /**
     * Log in to the background management system
     * 登录后台管理系统
     */
    public function Index(\XHB2\Request $request) {
        if($request->GetRequestMethod() == "POST"){
            $loginModel = new LoginModel();
            return Response::Output($loginModel->Login($request));
        }
        View::Make("Admin/Login/Index", [
            "request" => $request
        ]);
    }
}
?>