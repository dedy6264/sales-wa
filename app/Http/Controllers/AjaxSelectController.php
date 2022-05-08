<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxSelectController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, String $type)
    {
        if ($type == 'village'){
            return \DB::table('indonesia_villages')
                ->join('indonesia_districts', 'indonesia_districts.id', '=', 'indonesia_villages.district_id')
                ->join('indonesia_cities', 'indonesia_cities.id', '=', 'indonesia_districts.city_id')
                ->where('indonesia_villages.name', 'like', '%'.\Str::upper($request->term['term']).'%')
                ->orderBy('indonesia_cities.name')
                ->orderBy('indonesia_districts.name')
                ->orderBy('indonesia_villages.name')
                ->limit(30)
                ->get([
                    'indonesia_villages.id as id',
                    'indonesia_cities.name as uraiankota',
                    'indonesia_districts.name as uraiankecamatan',
                    'indonesia_villages.name as uraiandesa',
                ]);
                
        } elseif ($type == 'merchant') {
            return \DB::table('merchant')
                ->where('merchant_name', 'like', '%'.\Str::upper($request->term['term']).'%')
                ->orderBy('merchant_name')
                ->limit(30)
                ->get([
                    'id',
                    'merchant_name',
                ]);
        } 
    }
}
