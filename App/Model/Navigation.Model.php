<?php
namespace App\Model;

use XHB2\DatabaseManager;
use XHB2\SQLiteManager;

use function XHB2\CreateId;
use function XHB2\DD;
use function XHB2\StatusFailure;
use function XHB2\StatusSuccess;
use function XHB2\Translate;

class NavigationModel {

    public function List(\XHB2\Request &$request){
        $param = $request->Stream();
        $databaseManager = DatabaseManager::Instance();
        $sqlresult = "select Id,Title,Link,Status,Sort from Navigation where 1=1 order by Sort asc;";
        $itemData = $databaseManager->FetchAll($sqlresult, []);
        foreach($itemData as &$val){
            if($val["Status"] == 0){
                $val["StatusString"] = Translate($request->GetTranslate(), "StatusDelete");
            }
            if($val["Status"] == 1){
                $val["StatusString"] = Translate($request->GetTranslate(), "StatusNormal");
            }
            if($val["Status"] == 2){
                $val["StatusString"] = Translate($request->GetTranslate(), "StatusDeny");
            }
        }
        return $itemData;
    }

    /**
     * 添加导航
     */
    public function Add(\XHB2\Request &$request){
        $param = $request->Stream();
        if(!array_key_exists("Title", $param) || $param["Title"] == ""){
            return StatusFailure(Translate($request->GetTranslate(), "EnterTitle"));
        }
        $databaseManager = DatabaseManager::Instance();
        $fetchRow = $databaseManager->FetchRow("select Id,Translate from Navigation where Translate=:Translate and Title=:Title;", [
            "Translate" => $request->GetTranslate(),
            "Title" => $param["Title"],
        ]);
        if($fetchRow){
            return StatusFailure(Translate($request->GetTranslate(), "[{$param["Title"] }]导航已存在，请检查"));
        }
        $updateTime = date("Y-m-d H:i:s");
        $result = $databaseManager->Query("insert into Navigation (Id,Title,Link,Sort,Status,Translate) values (:Id,:Title,:Link,:Sort,:Status,:Translate);", [
            "Id" => CreateId(),
            "Title" => $param["Title"],
            "Link" => $param["Link"],
            "Sort" => $param["Sort"],
            "Status" => $param["Status"],
            "Translate" => $request->GetTranslate(),
        ]);
        if($result){
            return StatusSuccess(Translate($request->GetTranslate(), "StatusSuccess"));
        }
        return StatusFailure(Translate($request->GetTranslate(), "StatusFailure"));
    }

    /**
     * 编辑导航
     */
    public function Edit(\XHB2\Request &$request){
        $param = $request->Stream();
        if(!array_key_exists("Id", $param) || $param["Id"] == ""){
            return StatusFailure(Translate($request->GetTranslate(), "EnterId"));
        }
        if(!array_key_exists("Title", $param) || $param["Title"] == ""){
            return StatusFailure(Translate($request->GetTranslate(), "EnterTitle"));
        }
        $databaseManager = DatabaseManager::Instance();
        $result = $databaseManager->Query("update Navigation set Title=:Title,Link=:Link,Sort=:Sort,Status=:Status where Translate=:Translate and Id=:Id;", [
            "Id" => $param["Id"],
            "Translate" => $request->GetTranslate(),
            "Title" => $param["Title"],
            "Link" => $param["Link"],
            "Sort" => $param["Sort"],
            "Status" => $param["Status"]
        ]);
        if($result){
            return StatusSuccess(Translate($request->GetTranslate(), "StatusSuccess"));
        }
        return StatusFailure(Translate($request->GetTranslate(), "StatusFailure"));
    }

    /**
     * 删除导航
     */
    public function Delete(\XHB2\Request &$request){
        $param = $request->Stream();
        if(!array_key_exists("Id", $param) || $param["Id"] == ""){
            return StatusFailure(Translate($request->GetTranslate(), "EnterId"));
        }
        $databaseManager = DatabaseManager::Instance();
        $result = $databaseManager->Query("delete from Navigation where Id=:Id;", [
            "Id" => $param["Id"],
        ]);
        if($result){
            return StatusSuccess(Translate($request->GetTranslate(), "StatusSuccess"));
        }
        return StatusFailure(Translate($request->GetTranslate(), "StatusFailure"));
    }
    

    /**
     * 获取详情信息
     */
    public function GetDetail(\XHB2\Request &$request, string $Id){
        $fetchRow = DatabaseManager::Instance()->FetchRow("select Id,Title,Link,Sort,Status,Translate from Navigation where Translate=:Translate and Id=:Id;", [
            "Translate" => $request->GetTranslate(),
            "Id" => $Id,
        ]);
        if($fetchRow == false){
            return [];
        }
        return $fetchRow;
    }
}
?>