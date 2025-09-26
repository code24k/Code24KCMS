<?php
namespace App\Model;

use XHB2\DatabaseManager;
use XHB2\SQLiteManager;

use function XHB2\DD;
use function XHB2\StatusFailure;
use function XHB2\StatusSuccess;
use function XHB2\Translate;

class GlobalSettingModel {

    /**
     * Basic setup
     * 基础设置
     */
    public function SetBaseSetting(\XHB2\Request &$request){
        $param = $request->Stream();
        if(!array_key_exists("WebsiteName", $param) || $param["WebsiteName"] == ""){
            return StatusFailure(Translate($request->GetTranslate(), "EnterWebsiteName"));
        }
        if(count($param) > 0){
            $databaseManager = DatabaseManager::Instance();
            $updateTime = date("Y-m-d H:i:s");
            foreach($param as $key=>$val){
                $fetchRow = $databaseManager->FetchRow("select SettingKey,SettingValue,Translate from BaseSetting where Translate=:Translate and SettingKey=:SettingKey;", [
                    "Translate" => $request->GetTranslate(),
                    "SettingKey" => $key,
                ]);
                if($fetchRow === false){
                    $databaseManager->Query("insert into BaseSetting (SettingKey,SettingValue,UpdateTime,Translate) values (:SettingKey,:SettingValue,:UpdateTime,:Translate);", [
                        "SettingKey" => $key,
                        "SettingValue" => $val,
                        "UpdateTime" => $updateTime,
                        "Translate" => $request->GetTranslate(),
                    ]);
                }else{
                    $databaseManager->Query("update BaseSetting set SettingValue=:SettingValue,UpdateTime=:UpdateTime where SettingKey=:SettingKey and Translate=:Translate;", [
                        "SettingKey" => $key,
                        "SettingValue" => $val,
                        "UpdateTime" => $updateTime,
                        "Translate" => $request->GetTranslate(),
                    ]);
                }
            }
            return StatusSuccess(Translate($request->GetTranslate(), "StatusSuccess"));
        }
        return StatusFailure(Translate($request->GetTranslate(), "ConfigurationNotChanged"));
    }

    /**
     * Obtain the detailed information of the global Settings
     * 获取全局设置详情信息
     */
    public function GetDetail(\XHB2\Request &$request){
        return StatusSuccess(Translate($request->GetTranslate(), "StatusSuccess"), $this->GetBaseSetting($request));
    }

    /**
     * 获取全局设置
     */
    public function GetBaseSetting(\XHB2\Request &$request){
        $fetchAll = DatabaseManager::Instance()->FetchAll("select SettingKey,SettingValue,Translate from BaseSetting where Translate=:Translate;", [
            "Translate" => $request->GetTranslate()
        ]);
        $data = [];
        if(count($fetchAll) > 0){
            foreach($fetchAll as $key=>$item){
                $data[$item["SettingKey"]] = $item["SettingValue"];
            }
        }
        return $data;
    }
}
?>