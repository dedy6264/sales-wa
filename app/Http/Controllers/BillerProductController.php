<?php

namespace App\Http\Controllers;

use App\Models\{BillerProduct, BillerProductCategory, BillerProductType};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BillerProvider;
use App\Http\Requests\BillerProductRequest;
use DB;

class BillerProductController extends Controller
{
    
    public function index()
    {
        // $providerSelect = BillerProvider::get(['id', 'provider_name']);
        $categorySelect = BillerProductCategory::get(['id', 'product_category_name']);
        $typesSelect = BillerProductType::get(['id', 'product_type_name']);
        return view('contents.biller_product.index', compact('typesSelect', 'categorySelect'));
    }
    
    public function all(Request $request)
    {
        abort_if(!$request->header('X-XSRF-TOKEN'), 404);
        // return BillerProduct::leftjoin('provider','provider.id','=','product.product_role_assign_provider')
        // ->select(DB::raw("product.*, case when product.product_role_assign_provider is NULL then 'MULTI PROVIDER' ELSE provider.provider_name end as provider_name"))
        // ->get();
        return BillerProduct::select('*')->get();
    }
    
    public function store(BillerProductRequest $request)
    {
        $getDataTypeName = BillerProductType::whereId($request->product_type_id)->first()->product_type_name;
        $getDataCategoryName = BillerProductCategory::whereId($request->product_category_id)->first()->product_category_name;
        BillerProduct::create($request->validated()+[
            'product_type_name' => $getDataTypeName,
            'product_category_name' => $getDataCategoryName,
        ]);
        return true;
    }  
    public function update(BillerProductRequest $request, BillerProduct $product)
    {
        $getDataTypeName = BillerProductType::whereId($request->product_type_id)->first()->product_type_name;
        $getDataCategoryName = BillerProductCategory::whereId($request->product_category_id)->first()->product_category_name;
        $product->update($request->validated()+[
            'product_type_name' => $getDataTypeName,
            'product_category_name' => $getDataCategoryName,
        ]);
        return true;
    }
    public function destroy(BillerProduct $product)
    {
        $product->delete();
        return true;
    }
}