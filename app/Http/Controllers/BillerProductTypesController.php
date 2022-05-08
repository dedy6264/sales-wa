<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BillerProductType;
use App\Http\Controllers\Controller;
use App\Http\Requests\BillerProductTypesRequest;

class BillerProductTypesController extends Controller
{
    public function index()
    {
        return view('contents.biller_product_type.index');
    }
    public function all(Request $request){
        abort_if(!$request->header('X-XSRF-TOKEN'), 404);
        return BillerProductType::get();
    }
    public function store(BillerProductTypesRequest $request)
    {
        BillerProductType::create($request->validated());
        return true;
    }  
    public function update(BillerProductTypesRequest $request, BillerProductType $producttype)
    {
        $producttype->update($request->validated());
        return true;
    }
    public function destroy(BillerProductType $producttype)
    {
        $producttype->delete();
        return true;
    }
}
