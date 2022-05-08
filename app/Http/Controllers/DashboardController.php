<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        //pie chart
        $now            = Carbon::now();
        $dataBulan      = $now->month;
        $yearStart      = date('Y-01-01 00:00:00');
        $yearEnd        = date('Y-12-31 23:59:59');

        $dataBulanArray = ['January','February','March','April','May','June','July','August','September','October','November','December'];

        // $orders         =   DB::table('transaction')->whereBetween('created_at', [$yearStart, $yearEnd])
        //                     ->where('status_code','00')
        //                     ->get()
        //                     ->groupBy(function($d) {
        //                         return Carbon::parse($d->created_at)->format('m');
        //                     })
        //                     ->map(function($item, $key){
        //                         return [
        //                             'month' => Carbon::createFromFormat('m', $key)->format('F'),
        //                             'sum' => $item->sum('product_price')
        //                         ];
        //                     })
        //                     ->values()
        //                     ->all();

        $datapiefix =0;// collect($dataBulanArray)->map(function($item) use($orders) {
            // $sum = collect($orders)->firstWhere('month', $item)['sum'] ?? 0;
            // return [
            //     'name' => $item,
            //     'value' => $sum
            // ];
        // });
        // // SELESAI PREFIX

        // $totBalance                         = 0;
        // $totDebit                           = 0;
        // $totCredit                          = 0;
        // $tot_product_price                  = 0;
        // $tot_product_admin_fee              = 0;
        // $tot_product_merchant_fee           = 0;
        // $tot_product_provider_price         = 0;
        // $tot_product_provider_admin_fee     = 0;
        // $tot_product_provider_merchant_fee  = 0;
        // $startDate                          = date('Y-m-1 00:00:00');
        // $endDate                            = date('Y-m-t 23:59:59');
       
        // //tot Transaction
        // $opTransaction  =   DB::table('transaction')
        //                     ->select(
        //                         DB::raw("sum(product_price) as tot_product_price"), 
        //                         DB::raw("sum(product_admin_fee) as tot_product_admin_fee"), 
        //                         DB::raw("sum(product_merchant_fee) as tot_product_merchant_fee"), 
        //                         DB::raw("sum(product_provider_price) as tot_product_provider_price"), 
        //                         DB::raw("sum(product_provider_admin_fee) as tot_product_provider_admin_fee"), 
        //                         DB::raw("sum(product_provider_merchant_fee) as tot_product_provider_merchant_fee"), 
        //                     )
        //                 ->where('status_code', '00')
        //                 ->whereBetween('created_at', [$startDate, $endDate])
        //                 ->first();
        // $tot_product_price = $opTransaction->tot_product_price;
        // $tot_product_admin_fee = $opTransaction->tot_product_admin_fee;
        // $tot_product_merchant_fee = $opTransaction->tot_product_merchant_fee; 
        // $tot_product_provider_price = $opTransaction->tot_product_provider_price;
        // $tot_product_provider_admin_fee = $opTransaction->tot_product_provider_admin_fee;
        // $tot_product_provider_merchant_fee = $opTransaction->tot_product_provider_merchant_fee;

        $summaries = [
            'tot_product_price' =>0,
            'tot_product_admin_fee' =>0,
            'tot_product_merchant_fee' =>0,
            'tot_product_provider_price' =>0,
            'tot_product_provider_admin_fee' =>0,
            'tot_product_provider_merchant_fee' =>0,
        ];
        return view('contents.dashboard', compact('summaries','dataBulan','dataBulanArray','datapiefix'));
    }
}
