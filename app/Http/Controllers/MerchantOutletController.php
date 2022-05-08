<?php

namespace App\Http\Controllers;

use App\Models\MerchantOutlet;
use Illuminate\Http\Request;
use App\Http\Requests\MerchantOutletRequest;


class MerchantOutletController extends Controller
{
    public function index()
    {
        return view('contents.merchant_outlet.index');
    }
    public function all(Request $request)
    {
        $mainData=MerchantOutlet::join('merchant','merchant_outlet.merchant_id','=','merchant.id')
                ->select('merchant_outlet.*','merchant.merchant_name');
        return datatables()->of($mainData)
                ->addIndexColumn()
                ->make();
    }
    public function store(MerchantOutletRequest $request)
    {
        MerchantOutlet::create($request->validated());
        return true;
    }
    public function update(MerchantOutletRequest $request, MerchantOutlet $merchantOutlet)
    {
        $merchantOutlet->update($request->validated());
        return true;
    }
    public function destroy(MerchantOutlet $merchantOutlet)
    {
        $merchantOutlet->delete();
        return true;
    }
}
