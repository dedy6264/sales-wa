<?php

namespace App\Http\Controllers;

use App\Models\{Merchant};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;
use Carbon\Carbon;
use DB;



class BillerReportTransactionController extends Controller
{
    public function index()
    {
        $listMerchant = Merchant::get(['id', 'merchant_name']);
        $listMerchant->prepend([
            'id' => -1,
            'merchant_name' => 'ALL MERCHANT'
        ]);
        return view('contents.biller_report.index', compact('listMerchant'));
    }

    public function getFilterData(Request $request)
    {
        $status_code = $request->filter['status_code'];
        $merchant_id = $request->filter['merchant_id'];
        return DB::table('transaction')->whereBetween('created_at', [
                $request->filter['startDate'].' 00:00:00', $request->filter['endDate'].' 23:59:59'
            ])
            ->where('status_code', '!=', '66')
            ->when($status_code, function ($query, $status_code) {
                if ($status_code != -1) return $query->where('status_code', '=', (string)$status_code);
            })
            ->when($merchant_id, function ($query, $merchant_id) {
                if ($merchant_id != -1) return $query->where('merchant_id', $merchant_id);
            })
            ->orderBy('created_at','desc')
            ->get();
    }

    public function all(Request $request)
    {
        if($request->draw == 1){
            $dateValidation = $this->dateValidation($request->filter['startDate'], $request->filter['endDate']);
            if($dateValidation !== true) return response()->json([ 'message' => $dateValidation ], 406);
        }

        $mainData = $this->getFilterData($request);
        $response = datatables()->of($mainData)
            ->addIndexColumn()
            ->editColumn('created_at', function($item){
                return Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('Y-m-d H:i:s');
            })
            ->make();

        if($request->draw == 1){
            $summariesData = $this->getFilterData($request);
            
            $response->original['payload'] = [
                'productPrice' => $summariesData->sum('product_price'),
                'adminFee' => $summariesData->sum('product_admin_fee'),
                'merchantFee' => $summariesData->sum('product_merchant_fee'),
                'providerPrice' => $summariesData->sum('product_provider_price'),
                'providerAdminFee' => $summariesData->sum('product_provider_admin_fee'),
                'providerMerchantFee' => $summariesData->sum('product_provider_merchant_fee'),
            ];
        }

        return $response->original;
    }
    
    public function export_excel(Request $request)
    {   
        $mainData = $this->getFilterData($request);
        
        return (new FastExcel($mainData))->download('transaction.xlsx', function ($result) {
            return [
                'Created At'                        => $result->created_at,
                'Status'                            => $result->status_desc,
                'Client Name'                       => $result->client_name,
                'Region Name'                       => $result->region_name,
                'Group Name'                        => $result->group_name,
                'Merchant Name'                     => $result->merchant_name,
                'Merchant Outlet Name'              => $result->merchant_outlet_name,
                'Product Type Name'                 => $result->product_type_name,
                'Product Category Name'             => $result->product_category_name,
                'Product Unit Name'                 => $result->product_unit_name,
                'Product Code'                      => $result->product_code,
                'Product Name'                      => $result->product_name,
                'Product Price'                     => $result->product_price,
                'Product Admin Fee'                 => $result->product_admin_fee,
                'Product Merchant Fee'              => $result->product_merchant_fee,
                'Product Provider Code'             => $result->product_provider_code,
                'Product Provider Name'             => $result->product_provider_name,
                'Product Provider Price'            => $result->product_provider_price,
                'Product Provider Admin_fee'        => $result->product_provider_admin_fee,
                'Product Provider Merchant_fee'     => $result->product_provider_merchant_fee,
                'Transaction Number'                => $result->transaction_number,
                'Transaction Number Merchant'       => $result->transaction_number_merchant,
                'Transaction Number Merchant Index' => $result->transaction_number_merchant_index,
                'Transaction Number Provider'       => $result->transaction_number_provider,
                'Transaction Number Provider Index' => $result->transaction_number_provider_index,
            ];
        });
    }
    public function dateValidation(String $startDate, String $endDate)
    {
        $startValue = Carbon::create($startDate);
        $endValue = Carbon::create($endDate);
            
        if( $endValue > $startValue->copy()->addDays(30) ) 
            return 'End Date maksimal 31 hari setelah Start Date';
        
        if($startValue > $endValue) 
            return 'Format tanggal tidak sesuai';

        // else
        return true;
        
    }
}
