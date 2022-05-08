<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BillerProvider;
use App\Http\Controllers\Controller;
use App\Http\Requests\BillerProviderRequest;

class BillerProviderController extends Controller
{
    public function index()
    {
        return view('contents.biller_provider.index');
    }
    public function all(Request $request){
        abort_if(!$request->header('X-XSRF-TOKEN'), 404);
        return BillerProvider::get();
    }
    public function store(BillerProviderRequest $request)
    {
        BillerProvider::create($request->validated());
        return true;
    }  
    public function update(BillerProviderRequest $request, BillerProvider $billerprovider)
    {
        $billerprovider->update($request->validated());
        return true;
    }
    public function destroy(BillerProvider $billerprovider)
    {
        $billerprovider->delete();
        return true;
    }
}
