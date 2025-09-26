<?php
namespace App\Controller\Admin;

use App\Model\ProductCategoryModel;
use App\Model\GlobalSettingModel;
use App\Model\ProductModel;
use XHB2\View;
use XHB2\Response;

use function XHB2\DD;
use function XHB2\Translate;

class ProductController {

    /**
     * 
     * 产品列表
     */
    public function List(\XHB2\Request $request) {
        $productModel = new ProductModel();
        View::Make("Admin/Product/List", [
            "request" => $request,
            "urlParams" => $request->GetParseUrlParams(),
            "listData" => $productModel->List($request)
        ]);
    }

    /**
     * 新增产品
     */
    public function Add(\XHB2\Request $request) {
        if($request->GetRequestMethod() == "POST"){
            $productModel = new ProductModel();
            return Response::Output($productModel->Add($request));
        }
        $productCategoryModel = new ProductCategoryModel();
        View::Make("Admin/Product/Add", [
            "request" => $request,
            "getListArray" => $productCategoryModel->GetListArray($request)
        ]);
    }

    /**
     * 第二步骤
     */
    public function Second(\XHB2\Request $request) {
        if($request->GetRequestMethod() == "POST"){
            $productModel = new ProductModel();
            return Response::Output($productModel->Second($request));
        }
        $urlParams = $request->GetParseUrlParams();
        $productModel = new ProductModel();
        $detail = $productModel->GetDetail($request, $urlParams["Id"]);
        $productCategoryModel = new ProductCategoryModel();
        View::Make("Admin/Product/Second", [
            "request" => $request,
            "detail" => $detail,
            "getListArray" => $productCategoryModel->GetListArray($request)
        ]);
    }

    /**
     * 编辑产品
     */
    public function Edit(\XHB2\Request $request) {
        if($request->GetRequestMethod() == "POST"){
            $productModel = new ProductModel();
            return Response::Output($productModel->Edit($request));
        }
        $id = $request->GetParseUrlParamIndex(4);
        $productCategoryModel = new ProductCategoryModel();
        $productModel = new ProductModel();
        $detail = $productModel->GetDetail($request, $id);
        View::Make("Admin/Product/Edit", [
            "request" => $request,
            "detail" => $detail,
            "getListArray" => $productCategoryModel->GetListArray($request)
        ]);
    }

    /**
     * 删除产品
     */
    public function Delete(\XHB2\Request $request) {
        if($request->GetRequestMethod() == "POST"){
            $productModel = new ProductModel();
            return Response::Output($productModel->Delete($request));
        }
        $id = $request->GetParseUrlParamIndex(4);
        $productModel = new ProductModel();
        $detail = $productModel->GetDetail($request, $id);
        View::Make("Admin/Product/Delete", [
            "request" => $request,
            "detail" => $detail,
        ]);
    }

}
?>