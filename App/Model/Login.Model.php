<?php
namespace App\Model;

use XHB2\DatabaseManager;
use XHB2\SQLiteManager;

use function XHB2\DD;
use function XHB2\StatusFailure;
use function XHB2\StatusSuccess;
use function XHB2\Translate;

class LoginModel {

    /**
     * Log in to the background management system
     * 登录后台管理系统
     */
    public function Login(\XHB2\Request &$request){
        $param = $request->Stream();
        if(!array_key_exists("User", $param) || $param["User"] == ""){
            return StatusFailure(Translate($request->GetTranslate(), "EnterAccount"));
        }
        if(!array_key_exists("Passwd", $param) || $param["Passwd"] == ""){
            return StatusFailure(Translate($request->GetTranslate(), "EnterPassword"));
        }
        $result = DatabaseManager::Instance()->FetchRow("select User,Passwd from AdminUser where Status=1 and User=:User;", ["User" => $param["User"]]);
        if($result === false || count($result) == 0 || !array_key_exists("User", $result)){
            return StatusFailure(Translate($request->GetTranslate(), "AccountOrPasswordNotExists"));
        }
        if(md5($param["Passwd"]) != $result["Passwd"]){
            return StatusFailure(Translate($request->GetTranslate(), "AccountOrPasswordIncorrect"));
        }
        $token = md5(date("YmdHis").rand(1000, 9999));
        $result = $this->UpdateToken($param["User"], $token);
        if(!$result){
            return StatusFailure(Translate($request->GetTranslate(), "KeyUpdateFailed"));
        }
        return StatusSuccess("", ["Token" => $token]);
    }

    /**
     * Update the administrator token
     * 更新管理员密钥
     */
    public function UpdateToken(string &$user, string &$token){
        return DatabaseManager::Instance()->Query("update AdminUser set Token=:Token where User=:User", [
            "Token" => $token,
            "User" => $user
        ]);
    }
}
?>