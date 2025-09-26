<?php
namespace App\Model;

use XHB2\Common;
use XHB2\DatabaseManager;
use XHB2\SQLiteManager;

use function XHB2\CreateId;
use function XHB2\DD;
use function XHB2\StatusFailure;
use function XHB2\StatusSuccess;
use function XHB2\Translate;

class ProductModel {

    public function List(\XHB2\Request &$request){
        $param = $request->Stream();
        $paramId = "";
        if($request->GetParseUrlParam("Id") != ""){
            $paramId = $request->GetParseUrlParam("Id");
        }
        $paramTitle = "";
        if($request->GetParseUrlParam("Title") != ""){
            $paramTitle = $request->GetParseUrlParam("Title");
        }

        $pageCurrent = 1;
        if($request->GetParseUrlParam("PageCurrtent") != ""){
            $pageCurrent = (int) $request->GetParseUrlParam("PageCurrtent");
            if($pageCurrent <= 0){
                $pageCurrent = 1;
            }
        }
        $pageLimit = 10;
        $pagePffset = 0;
        if ($pageCurrent > 0){
            $pagePffset = ($pageCurrent - 1) * $pageLimit;
        }
        $limit = " limit {$pageLimit} offset {$pagePffset} ";

        $getTranslate = $request->GetTranslate();
        $where = " 1=1 and Translate='{$getTranslate}' and Status>0 ";
        if ($paramId != "") {
            $where .= " and Id='{$paramId}' ";
        }
        if ($paramTitle != "") {
            $where .= " and Title like '%{$paramTitle}%' ";
        }
        $sqlCount = "select count(Id) countTotal from Product where {$where};";

        $databaseManager = DatabaseManager::Instance();
        $fetchRow = $databaseManager->FetchRow($sqlCount, []);
        $countTotal = 0;
        $pageTotal = 0;
        if($fetchRow && is_array($fetchRow)){
            $countTotal = $fetchRow["countTotal"];
        }
        if ($countTotal%$pageLimit == 0) {
            $pageTotal = $countTotal / $pageLimit;
        } else {
            $pageTotal = intval(($countTotal/$pageLimit)) + 1;
        }
        if($pageCurrent >= $pageTotal){
            $pageCurrent = $pageTotal;
        }
        $sqlresult = "select Id,Title,Status,CreateTime,UpdateTime,CoverImage from Product where {$where} order by CreateTime desc {$limit};";
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
            $val["UpdateTimeString"] = substr($val["UpdateTime"], 0, 10);
        }
        return [
            "PageTotal" => $pageTotal,
            "ItemData" => $itemData,
            "PageCurrent" => $pageCurrent,
        ];
    }

    /**
     * 添加产品
     */
    public function Add(\XHB2\Request &$request){
        $param = $request->Stream();
        if(!array_key_exists("Title", $param) || $param["Title"] == ""){
            return StatusFailure(Translate($request->GetTranslate(), "EnterTitle"));
        }
        $paramCreateTime = date("Y-m-d H:i:s");
        if(array_key_exists("CreateTime", $param) && $param["CreateTime"] != ""){
            $paramCreateTime = trim($param["CreateTime"]) . date(" H:i:s");
        }
        $databaseManager = DatabaseManager::Instance();
        $fetchRow = $databaseManager->FetchRow("select Id,Translate from Product where Translate=:Translate and Title=:Title;", [
            "Translate" => $request->GetTranslate(),
            "Title" => $param["Title"],
        ]);
        if($fetchRow){
            return StatusFailure(Translate($request->GetTranslate(), "[{$param["Title"] }]已存在，请检查"));
        }
        $Id = CreateId();
        $result = $databaseManager->Query("insert into Product (ProductCategoryId,Id,Title,Keywords,Description,Content,Visits,Status,CreateTime,UpdateTime,CoverImage,Translate) values (:ProductCategoryId,:Id,:Title,:Keywords,:Description,:Content,:Visits,:Status,:CreateTime,:UpdateTime,:CoverImage,:Translate);", [
            "ProductCategoryId" => 0,
            "Id" => $Id,
            "Title" => $param["Title"],
            "Keywords" => "",
            "Description" => "",
            "Content" => "",
            "Visits" => rand(100, 999),
            "Status" => 1,
            "CreateTime" => $paramCreateTime,
            "UpdateTime" => date("Y-m-d H:i:s"),
            "CoverImage" => "",
            "Translate" => $request->GetTranslate(),
        ]);
        if($result){
            return StatusSuccess(Translate($request->GetTranslate(), "StatusSuccess"), ["Id" => $Id]);
        }
        return StatusFailure(Translate($request->GetTranslate(), "StatusFailure"));
    }

    /**
     * 添加产品步骤二
     */
    public function Second(\XHB2\Request &$request){
        $param = $request->Stream();
        if(!array_key_exists("Id", $param) || $param["Id"] == ""){
            return StatusFailure(Translate($request->GetTranslate(), "缺少产品ID，这是一个无效的产品，请返回重新操作。"));
        }
        $paramId = trim($param["Id"]);
        $paramCreateTime = date("Y-m-d H:i:s");
        if(array_key_exists("CreateTime", $param) && $param["CreateTime"] != ""){
            $paramCreateTime = trim($param["CreateTime"]) . date(" H:i:s");
        }
        $paramProductCategoryId = 0;
        if(array_key_exists("ProductCategoryId", $param) && $param["ProductCategoryId"] != ""){
            $paramProductCategoryId = intval($param["ProductCategoryId"]);
        }
        $paramCoverImage = "";
        $Common = new \XHB2\Common();
        $extractAllImageSources = $Common->ExtractAllImageSources($param["Content"]);
        if(count($extractAllImageSources) > 0){
            $paramCoverImage = $extractAllImageSources[0];
        }
        $result = DatabaseManager::Instance()->Query("update Product set ProductCategoryId=:ProductCategoryId,Keywords=:Keywords,Description=:Description,Content=:Content,Visits=:Visits,Status=:Status,UpdateTime=:UpdateTime,CoverImage=:CoverImage where Translate=:Translate and Id=:Id;", [
            "ProductCategoryId" => $paramProductCategoryId,
            "Id" => $paramId,
            "Keywords" => $param["Keywords"],
            "Description" => $param["Description"],
            "Content" => $param["Content"],
            "Visits" => $param["Visits"],
            "Status" => $param["Status"],
            "UpdateTime" => date("Y-m-d H:i:s"),
            "CoverImage" => $paramCoverImage,
            "Translate" => $request->GetTranslate(),
        ]);
        if($result){
            return StatusSuccess(Translate($request->GetTranslate(), "StatusSuccess"));
        }
        return StatusFailure(Translate($request->GetTranslate(), "StatusFailure"));
    }

    /**
     * 编辑单页
     */
    public function Edit(\XHB2\Request &$request){
        $param = $request->Stream();
        if(!array_key_exists("Id", $param) || $param["Id"] == ""){
            return StatusFailure(Translate($request->GetTranslate(), "EnterId"));
        }
        $Id = trim($param["Id"]);
        if(!array_key_exists("Title", $param) || $param["Title"] == ""){
            return StatusFailure(Translate($request->GetTranslate(), "EnterTitle"));
        }
        $databaseManager = DatabaseManager::Instance();
        $updateTime = date("Y-m-d H:i:s");
        $result = $databaseManager->Query("update Product set Title=:Title,UpdateTime=:UpdateTime where Translate=:Translate and Id=:Id;", [
            "Id" => $param["Id"],
            "Translate" => $request->GetTranslate(),
            "Title" => $param["Title"],
            "UpdateTime" => $updateTime,
        ]);
        if($result){
            return StatusSuccess(Translate($request->GetTranslate(), "StatusSuccess"), ["Id" => $Id]);
        }
        return StatusFailure(Translate($request->GetTranslate(), "StatusFailure"));
    }

    /**
     * 删除单页
     */
    public function Delete(\XHB2\Request &$request){
        $param = $request->Stream();
        if(!array_key_exists("Id", $param) || $param["Id"] == ""){
            return StatusFailure(Translate($request->GetTranslate(), "EnterId"));
        }
        $databaseManager = DatabaseManager::Instance();
        $result = $databaseManager->Query("delete from Product where Id=:Id;", [
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
        $fetchRow = DatabaseManager::Instance()->FetchRow("select ProductCategoryId,Id,Title,Keywords,Description,Content,Visits,Status,CreateTime,UpdateTime,Translate from Product where Translate=:Translate and Id=:Id;", [
            "Translate" => $request->GetTranslate(),
            "Id" => $Id,
        ]);
        if($fetchRow == false){
            return [];
        }
        if(is_array($fetchRow) && count($fetchRow)){
            $fetchRow["CreateTime"] = substr($fetchRow["CreateTime"], 0, 10);
        }
        return $fetchRow;
    }

    /**
     * 最新产品20
     */
    public function ProductListNew15(\XHB2\Request &$request){
        $param = $request->Stream();
        $getTranslate = $request->GetTranslate();
        $where = " 1=1 and Translate='{$getTranslate}' and Status=1 ";
        $databaseManager = DatabaseManager::Instance();
        $sqlresult = "select Id,Title,Status,CreateTime,CoverImage from Product where {$where} order by CreateTime desc limit 20;";
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
}
?>