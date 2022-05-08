<?php

namespace App\Http\Controllers;
use DB;
use App\Models\{AccountTransaction,AccountTransactionType,Account};
use App\Http\Requests\TopUpRequest;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Carbon\Carbon;
use App\Http\Controllers\Controller;



class TopUpController extends Controller
{
    public function checkDaterange(Request $request)
    {
        $startValue = strtotime($request->startDate);
        $endValue   = strtotime($request->endDate);

        if( strtotime('+30 days', $startValue) < $endValue ) 
            return response()->json([ 'message' => 'Maksimal Filter 31 Hari' ], 406);

        if($startValue > $endValue) 
            return response()->json([ 'message' => 'Format tanggal tidak sesuai' ], 406);

        return true;
    }
    public function getFilterData(Request $request)
    {
        return AccountTransaction::join('merchant','merchant.id','=','account_transaction.merchant_id')
            ->whereBetween('account_transaction.created_at', [$request->filter['startDate'].' 00:00:00', $request->filter['endDate'].' 23:59:59' ])
            ->where('account_transaction_type_dk','C')
            ->where('account_transaction_status_reversal','NO')
            ->select(['account_transaction.*',
            'merchant.merchant_name',
            'merchant_outlet_name'])
            ->orderBy('account_transaction.created_at','desc')
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
                'balance' => $summariesData->sum('account_last_balance'),
                'ammount' => $summariesData->sum('account_transaction_amount'),
                'transactionAmmount' => $summariesData->sum('account_transaction_last_balance'),
            ];
        }

        return $response->original;
        // abort_if(!$request->header('X-CSRF-TOKEN'), 404);
        
        // $startValue  = strtotime($request->filter['startDate']);
        // $endValue    = strtotime($request->filter['endDate']);

        // $startValue2 = date("Y-m-d 00:00:00", $startValue);
        // $endValue2   = date("Y-m-d 23:59:59", $endValue);

        // $result = AccountTransaction::join('merchant','merchant.id','=','account_transaction.merchant_id')
        //     ->whereBetween('account_transaction.created_at', [$startValue2, $endValue2])
        //     ->where('account_transaction_type_dk','C')
        //     ->select(['account_transaction.*',
        //             'merchant.merchant_name',
        //             'merchant_outlet_name'])
        //     ->get();
        // $mainData = datatables()->of($result)
        //     ->addIndexColumn()
        //     ->make();
        // return $mainData;
    }
    public function index()
    {
        $transactiontype = AccountTransactionType::where('account_transaction_type_dk','C')
                            ->get();
        $result          = Account::join('merchant','account.merchant_id','=','merchant.id')
                            ->select('account.id','account.account_number','merchant.merchant_name')
                            ->get();
        return view('contents.top_up.index',compact('result','transactiontype'));
    }
    
    
    
    
    public function store(TopUpRequest $request)
    {
        
        $account=DB::table('account')
                ->where('id',$request->account_id)
                ->select('account_number','account_last_balance','merchant_id')
                ->first();
        $accounttransactiontype=AccountTransactionType::where('id',$request->account_transaction_type_id)
                ->select('account_transaction_type_code','account_transaction_type_desc','account_transaction_type_dk')
                ->first();
        
        $rand        = rand(1,1000);
        $zeropadding = str_pad($rand,4,"0",STR_PAD_LEFT);
        $dbTime      = date('YmdHis');
        $nobukti     = "SAV-".$dbTime . $zeropadding;
                    
                    
        DB::table('account_transaction')
        ->insert([
           'account_id'                         =>$request->account_id,
           'account_number'                     =>$account->account_number,
           'merchant_id'                        =>$account->merchant_id,
           'merchant_outlet_id'                 =>'0',
           'merchant_outlet_name'               =>'-', 
           'account_transaction_number'         =>$nobukti, //generating
           'account_transaction_number_reff'    =>$request->num_reff,
           'account_transaction_desc'           =>'PAYMENT',
           'account_transaction_type_code'      =>$accounttransactiontype->account_transaction_type_code,
           'account_transaction_type_desc'      =>$accounttransactiontype->account_transaction_type_desc,
           'account_transaction_type_dk'        =>$accounttransactiontype->account_transaction_type_dk,
           'account_last_balance'               =>$account->account_last_balance,
           'account_transaction_amount'         =>$request->ammount,
           'account_transaction_last_balance'   =>(int)$account->account_last_balance+(int)$request->ammount,
           'account_transaction_status_reversal'=>'NO',
           'created_at'                         =>now(),
        ]);

        DB::table('account')
        ->where('id',$request->account_id)
        ->increment('account_last_balance',$request->ammount);
        return true;
    }  
    public function exportExcel(Request $request)
    {
        $startValue2 = date("Y-m-d 00:00:00", strtotime($request->filter['startDate']));
        $endValue2   = date("Y-m-d 23:59:59", strtotime($request->filter['endDate']));
        try {

            $mainData = AccountTransaction::join('merchant','merchant.id','=','account_transaction.merchant_id')
            ->whereBetween('account_transaction.created_at', [$startValue2, $endValue2])
            ->where('account_transaction_type_dk','C')
            ->select(['account_transaction.*',
            'merchant.merchant_name',
            'merchant_outlet_name'])
            ->get()
            ->map(function($item, $index){
                return collect($item)->merge([
                    'index' => ($index+1),
                ])->all();
            });

            return (new FastExcel(collect($mainData)))->download('TopUp.xlsx', function ($item) {
                return [
                    '#'                                => $item['index'],
                    'Account Number'                   => $item['account_number'],
                    'Merchant Name'                    => $item['merchant_name'],
                    'Merchant Outlet ID'               => $item['merchant_outlet_id'],
                    'Merchant Outlet Name'             => $item['merchant_outlet_name'],
                    'Account Transaction Number'       => $item['account_transaction_number'],
                    'Account Transaction Number Reff'  => $item['account_transaction_number_reff'],
                    'Account Transaction Type Code'    => $item['account_transaction_type_code'],
                    'Account Transaction Type Desc'    => $item['account_transaction_type_desc'],
                    'Account Transaction Desc'         => $item['account_transaction_desc'],
                    'Account Balance'                  => $item['account_last_balance'],
                    'Amount'                           => $item['account_transaction_amount'],
                    'Account Last Balance'             => $item['account_transaction_last_balance'],
                    'Account Transaction Type DK'      => $item['account_transaction_type_dk'],
                    'Status Reversal'                  => $item['account_transaction_status_reversal'],
                    'Created At'                       => $item['created_at']
                ];
            });
            
        } catch (\Exception $e) {
            return response()->json([
                'message'            => 'Maaf terjadi kesalahan',
                'additional message' => $e->getMessage()
            ], 409);
        }
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
