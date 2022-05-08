<?php

namespace App\Http\Controllers;

use App\Models\{AccountTransaction};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class BillerController extends Controller
{
    public function checkDaterange(Request $request)
    {
        $startValue = strtotime($request->startDate);
        $endValue = strtotime($request->endDate);

        if( strtotime('+30 days', $startValue) < $endValue ) 
            return response()->json([ 'message' => 'Maksimal Filter 31 Hari' ], 406);

        if($startValue > $endValue) 
            return response()->json([ 'message' => 'Format tanggal tidak sesuai' ], 406);

        return true;
    }

    public function all(Request $request)
    {
        abort_if(!$request->header('X-CSRF-TOKEN'), 404);
        
        $startValue = strtotime($request->filter['startDate']);
        $endValue = strtotime($request->filter['endDate']);

        $startValue2 = date("Y-m-d 00:00:00", $startValue);
        $endValue2 = date("Y-m-d 23:59:59", $endValue);

        $result = AccountTransaction::whereBetween('created_at', [$startValue2, $endValue2])
            ->get();
        $mainData = datatables()->of($result)
            ->addIndexColumn()
            ->make();
        return $mainData;
    }
    
    public function index()
    {
        return view('contents.biller.index');
    }
}