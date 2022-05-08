<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BillerProduct;
use App\Models\BillerProvider;
use App\Http\Controllers\Controller;
use App\Models\BillerProductProvider;
use App\Http\Requests\BillerProductProviderRequest;

class BillerProductProviderController extends Controller
{
    public function index()
    {
        $productSelect = BillerProduct::get(['id', 'product_code']);
        $providerSelect = BillerProvider::get(['id', 'provider_name']);
        return view('contents.biller_product_provider.index', compact('productSelect','providerSelect'));
    }
    public function all(Request $request){
        abort_if(!$request->header('X-XSRF-TOKEN'), 404);
        return BillerProductProvider::join('product','product.id','=','product_provider.product_id')
        ->select('product_provider.*',
        'product.product_code',
        // 'product.product_price',
        'product.product_name')
        ->orderBy('product_provider_code','asc')
        ->get();
    }
    public function store(BillerProductProviderRequest $request)
    {
        BillerProductProvider::create($request->validated());
        return true;
    }  
    public function update(BillerProductProviderRequest $request, BillerProductProvider $productprovider)
    {
        $productprovider->update($request->validated());
        return true;
    }
    public function destroy(BillerProductProvider $productprovider)
    {
        $productprovider->delete();
        return true;
    }
}
