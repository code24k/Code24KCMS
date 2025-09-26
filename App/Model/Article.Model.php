<?php
namespace App\Model;

use XHB2\DatabaseManager;
use XHB2\SQLiteManager;

use function XHB2\CreateId;
use function XHB2\DD;
use function XHB2\StatusFailure;
use function XHB2\StatusSuccess;
use function XHB2\Translate;

class ArticleModel {

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
        $sqlCount = "select count(Id) countTotal from Article where {$where};";

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
        $sqlresult = "select Id,Title,Status,CreateTime,UpdateTime from Article where {$where} order by CreateTime desc {$limit};";
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
     * 添加文章
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
        $paramArticleCategoryId = 0;
        if(array_key_exists("ArticleCategoryId", $param) && $param["ArticleCategoryId"] != ""){
            $paramArticleCategoryId = intval($param["ArticleCategoryId"]);
        }
        $databaseManager = DatabaseManager::Instance();
        $fetchRow = $databaseManager->FetchRow("select Id,Translate from Article where Translate=:Translate and Title=:Title;", [
            "Translate" => $request->GetTranslate(),
            "Title" => $param["Title"],
        ]);
        if($fetchRow){
            return StatusFailure(Translate($request->GetTranslate(), "[{$param["Title"] }]已存在，请检查"));
        }
        $result = $databaseManager->Query("insert into Article (ArticleCategoryId,Id,Title,Keywords,Description,Content,Visits,Status,CreateTime,UpdateTime,Translate) values (:ArticleCategoryId,:Id,:Title,:Keywords,:Description,:Content,:Visits,:Status,:CreateTime,:UpdateTime,:Translate);", [
            "ArticleCategoryId" => $paramArticleCategoryId,
            "Id" => CreateId(),
            "Title" => $param["Title"],
            "Keywords" => $param["Keywords"],
            "Description" => $param["Description"],
            "Content" => $param["Content"],
            "Visits" => $param["Visits"],
            "Status" => $param["Status"],
            "CreateTime" => $paramCreateTime,
            "UpdateTime" => date("Y-m-d H:i:s"),
            "Translate" => $request->GetTranslate(),
        ]);
        if($result){
            return StatusSuccess(Translate($request->GetTranslate(), "StatusSuccess"));
        }
        return StatusFailure(Translate($request->GetTranslate(), "StatusFailure"));
    }

    /**
     * 编辑文章
     */
    public function Edit(\XHB2\Request &$request){
        $param = $request->Stream();
        if(!array_key_exists("Id", $param) || $param["Id"] == ""){
            return StatusFailure(Translate($request->GetTranslate(), "EnterId"));
        }
        if(!array_key_exists("Title", $param) || $param["Title"] == ""){
            return StatusFailure(Translate($request->GetTranslate(), "EnterTitle"));
        }
        $paramCreateTime = date("Y-m-d H:i:s");
        if(array_key_exists("CreateTime", $param) && $param["CreateTime"] != ""){
            $paramCreateTime = trim($param["CreateTime"]) . date(" H:i:s");
        }
        $paramArticleCategoryId = 0;
        if(array_key_exists("ArticleCategoryId", $param) && $param["ArticleCategoryId"] != ""){
            $paramArticleCategoryId = intval($param["ArticleCategoryId"]);
        }
        $databaseManager = DatabaseManager::Instance();
        $updateTime = date("Y-m-d H:i:s");
        $result = $databaseManager->Query("update Article set ArticleCategoryId=:ArticleCategoryId,Title=:Title,Keywords=:Keywords,Description=:Description,Content=:Content,Visits=:Visits,Status=:Status,CreateTime=:CreateTime,UpdateTime=:UpdateTime where Translate=:Translate and Id=:Id;", [
            "ArticleCategoryId" => $paramArticleCategoryId,
            "Id" => $param["Id"],
            "Translate" => $request->GetTranslate(),
            "Title" => $param["Title"],
            "Keywords" => $param["Keywords"],
            "Description" => $param["Description"],
            "Content" => $param["Content"],
            "Visits" => $param["Visits"],
            "Status" => $param["Status"],
            "CreateTime" => $paramCreateTime,
            "UpdateTime" => $updateTime,
        ]);
        if($result){
            return StatusSuccess(Translate($request->GetTranslate(), "StatusSuccess"));
        }
        return StatusFailure(Translate($request->GetTranslate(), "StatusFailure"));
    }

    /**
     * 删除文章
     */
    public function Delete(\XHB2\Request &$request){
        $param = $request->Stream();
        if(!array_key_exists("Id", $param) || $param["Id"] == ""){
            return StatusFailure(Translate($request->GetTranslate(), "EnterId"));
        }
        $databaseManager = DatabaseManager::Instance();
        $result = $databaseManager->Query("delete from Article where Id=:Id;", [
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
        $fetchRow = DatabaseManager::Instance()->FetchRow("select ArticleCategoryId,Id,Title,Keywords,Description,Content,Visits,Status,CreateTime,UpdateTime,Translate from Article where Translate=:Translate and Id=:Id;", [
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
     * 最新文章15
     */
    public function ArticleListNew10(\XHB2\Request &$request){
        $getTranslate = $request->GetTranslate();
        $where = " 1=1 and Translate='{$getTranslate}' and Status>0 ";
        $databaseManager = DatabaseManager::Instance();
        $sqlresult = "select Id,Title,Status,CreateTime,UpdateTime from Article where {$where} order by CreateTime desc limit 15;";
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
        return $itemData;
    }
}
?>