<?php

namespace App\Http\Controllers;

use App\Models\BillerProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BillerProductCategoryRequest;

class BillerProductCategoryController extends Controller
{
    public function index()
    {
        return view('contents.biller_product_category.index');
    }
    public function all(Request $request){
        abort_if(!$request->header('X-XSRF-TOKEN'), 404);
        return BillerProductCategory::get();
    }
    public function store(BillerProductCategoryRequest $request)
    {
        BillerProductCategory::create($request->validated());
        return true;
    }  
    public function update(BillerProductCategoryRequest $request, BillerProductCategory $productcategory)
    {
        $productcategory->update($request->validated());
        return true;
    }
    public function destroy(BillerProductCategory $productcategory)
    {
        $productcategory->delete();
        return true;
    }
}
