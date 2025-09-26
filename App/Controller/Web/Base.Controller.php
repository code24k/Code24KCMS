<?php
namespace App\Controller\Web;

class BaseController {

    public function __construct() {
        
    }

    public function __destruct()
    {
        
    }

    public function Befor(\XHB2\Request $request){
        $translate = \XHB2\Config("Translate");
        if(is_array($translate) && count($translate["Support"]) > 0){
            if(!in_array($request->GetTranslate(), $translate["Support"])){
                \XHB2\DD("Error!\App\Config\Translate\Support{".$request->GetTranslate()."}");
            }
        }
        $this->SetWebsiteTitle($request);
    }

    public function After(\XHB2\Request $request){

    }

    public function SetWebsiteTitle(\XHB2\Request $request){
        $globalSettingModel = new \App\Model\GlobalSettingModel();
        $getBaseSetting = $globalSettingModel->GetBaseSetting($request);
        if(is_array($getBaseSetting) && array_key_exists("WebsiteName", $getBaseSetting)){
            $response = \XHB2\Response::Instance();
            $response->SetWebsiteTitle($getBaseSetting["WebsiteName"]);
            $response->SetSeoKeywords($getBaseSetting["WebsiteKeywords"]);
            $response->SetSeoDescription($getBaseSetting["WebsiteDescription"]);
        }else{
            $response = \XHB2\Response::Instance();
            $response->SetWebsiteTitle("No Title");
        }
    }
}
?>