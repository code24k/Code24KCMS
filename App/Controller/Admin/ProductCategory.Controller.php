<?php
namespace App\Controller\Admin;

use App\Model\GlobalSettingModel;
use App\Model\ProductCategoryModel;
use XHB2\View;
use XHB2\Response;

use function XHB2\DD;
use function XHB2\Translate;

class ProductCategoryController {

    /**
     * 
     * 类别列表
     */
    public function List(\XHB2\Request $request) {
        $productCategoryModel = new ProductCategoryModel();
        View::Make("Admin/ProductCategory/List", [
            "request" => $request,
            "urlParams" => $request->GetParseUrlParams(),
            "listData" => $productCategoryModel->List($request)
        ]);
    }

    /**
     * 新增类别
     */
    public function Add(\XHB2\Request $request) {
        if($request->GetRequestMethod() == "POST"){
            $productCategoryModel = new ProductCategoryModel();
            return Response::Output($productCategoryModel->Add($request));
        }
        View::Make("Admin/ProductCategory/Add", [
            "request" => $request
        ]);
    }

    /**
     * 编辑类别
     */
    public function Edit(\XHB2\Request $request) {
        if($request->GetRequestMethod() == "POST"){
            $productCategoryModel = new ProductCategoryModel();
            return Response::Output($productCategoryModel->Edit($request));
        }
        $id = $request->GetParseUrlParamIndex(4);
        $productCategoryModel = new ProductCategoryModel();
        $detail = $productCategoryModel->GetDetail($request, $id);
        View::Make("Admin/ProductCategory/Edit", [
            "request" => $request,
            "detail" => $detail,
        ]);
    }

    /**
     * 删除类别
     */
    public function Delete(\XHB2\Request $request) {
        if($request->GetRequestMethod() == "POST"){
            $productCategoryModel = new ProductCategoryModel();
            return Response::Output($productCategoryModel->Delete($request));
        }
        $id = $request->GetParseUrlParamIndex(4);
        $productCategoryModel = new ProductCategoryModel();
        $detail = $productCategoryModel->GetDetail($request, $id);
        View::Make("Admin/ProductCategory/Delete", [
            "request" => $request,
            "detail" => $detail,
        ]);
    }

}
?>