<?php

namespace App\Http\Controllers;

use App\Models\{BillerProviderEnv, BillerProvider};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BillerProviderEnvRequest;

class BillerProviderEnvController extends Controller
{
    public function index()
    {
        $providerSelect = BillerProvider::get(['id', 'provider_name']);
        return view('contents.biller_provider_env.index', compact('providerSelect'));
    }
    public function all(Request $request){
        abort_if(!$request->header('X-XSRF-TOKEN'), 404);
        return BillerProviderEnv::get();
    }
    public function store(BillerProviderEnvRequest $request)
    {
        BillerProviderEnv::create($request->validated());
        return true;
    }  
    public function update(BillerProviderEnvRequest $request, BillerProviderEnv $billerproviderenv)
    {
        $billerproviderenv->update($request->validated());
        return true;
    }
    public function destroy(BillerProviderEnv $billerproviderenv)
    {
        $billerproviderenv->delete();
        return true;
    }
}
