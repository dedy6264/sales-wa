<?php

namespace App\Http\Controllers;

use App\Models\{Merchant, Group};
use Illuminate\Http\Request;
use App\Http\Requests\MerchantRequest;
use DB;
class MerchantController extends Controller
{
    public function index()
    {
        $group =    Group::get(['id', 'group_name']);
        $payment=   DB::table('payment_method')
                    ->get(['id', 'payment_method_name']);
        $segment=   DB::table('segment')
                    ->get(['id', 'segment_name']);
        return view('contents.merchant.index', compact('group','payment','segment'));
    }
    public function all(Request $request)
    {
        $mainData = Merchant::join('group', 'merchant.group_id', '=', 'group.id')
            ->join('indonesia_villages', 'merchant.village_id', '=', 'indonesia_villages.id')
            ->join('indonesia_districts', 'indonesia_districts.id', '=', 'indonesia_villages.district_id')
            ->join('indonesia_cities', 'indonesia_cities.id', '=', 'indonesia_districts.city_id')
            ->join('payment_method', 'payment_method.id', '=', 'merchant.payment_method_id')
            ->join('segment', 'segment.id', '=', 'merchant.segment_id')
            ->select('merchant.*', 'group.group_name',
                'indonesia_cities.name as uraiankota',
                'indonesia_districts.name as uraiankecamatan',
                'indonesia_villages.name as uraiandesa',
                'segment.id as segment_id',
                'segment.segment_name',
                'payment_method.payment_method_name'
            );
        return datatables()->of($mainData)
            ->addIndexColumn()
            ->make();
    }
    public function store(MerchantRequest $request)
    {
        dump($request->all());
        Merchant::create($request->validated());
        return true;
    }
    public function update(MerchantRequest $request, Merchant $merchant)
    {
        dump($request->all());

        $merchant->update($request->validated());
        return true;
    }
    public function destroy(Merchant $merchant)
    {
        $merchant->delete();
        return true;
    }
}
