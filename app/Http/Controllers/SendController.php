<?php

namespace App\Http\Controllers;

use App\Models\Send;
use Illuminate\Http\Request;
use App\Http\Requests\SendRequest;
use DB;
use Illuminate\Support\Facades\Http;

class SendController extends Controller
{
    public function index()
    {
        $dataMessage = DB::table('message')->get();
        $dataType = DB::table('broadcast_type')->get();
        $dataClient = DB::table('client')->get();
       
        return view('contents.send.index', compact('dataMessage','dataClient','dataType'));
    }
    public function all(Request $request)
    {
        abort_if(!$request->header('X-XSRF-TOKEN'), 404);
        return Send::join('message','message.id','=','send.message_id')
        ->join('client','client.id','=','send.client_id')
        ->where('send.status','0')
        ->get([
            'send.*',
            'client.client_phone',
            'client.client_name',
            'message.title',
            'message.message',
        ]);
        
    }
    public function store(SendRequest $request)
    {
        // dd($request->all());
        if(!$request->client_id){
            //$client_phone=DB::table('client')->where('id',1)->select('id')->get();
            $payload=[
                'id'=>$request->id,
                'message_id'=>$request->message_id,
                'index'=>'0'.$request->message_id,
                'client_id'=>1,
                'broadcast_type_id'=>$request->broadcast_type,
                'status'=>0,
            ];
            // dd($payload);
        }else{
            // $client=DB::table('client')
            // ->where('id',$request->client_id)
            // ->select('client_phone')->first();
            $payload=[
                'id'=>$request->id,
                'message_id'=>$request->message_id,
                'client_id'=>$request->client_id,
                'index'=>$request->client_id.$request->message_id,
                'broadcast_type_id'=>$request->broadcast_type,
                'status'=>0,
            ];
            // dd($payload);
        }
            // dump($payload);
            $save=Send::create($payload);
        return $save;
    }
    public function update(SendRequest $request, Send $send)
    {
        $send->update($request->validated());
        return true;
    }
    public function destroy(Send $send)
    {
        $send->delete();
        return true;
    }
    public function send(Request $request)
    {  //dd($request->all());
        try{
        if($request->broadcast_type_id==1){
            $max=DB::table('client')->select(DB::raw('count(id)'))->first();
            $nomer=DB::table('client')->select('client_phone')->get();
            $text=DB::table('send')->join('message','message.id','=','send.message_id')
            // ->join('client','client.id','=','send.client_id')
            ->where('send.id',$request->id)
            ->select('message.message')->first();
            dd($nomer);
            for ($i=0; $i < $max->count ; $i++) { 
                // $payload=[
                //     'nomer'=>"89678971119",//substr($nomer[$i]->client_phone,1),
                //     'text'=>$text->message,
                // ];
                // $response=HTTP::post('http://localhost:10010/whatsapp/v1/send',$payload)->json();
        // return $response;
                     $res = HTTP::post('http://localhost:8000/send-message', [
                         'form_params' => [
                             'number'=>"6289678971119@c.us",//substr($nomer[$i]->client_phone,1),
                                 'message'=>$text->message,
                         ]
                     ]);
        

            }
        }else{       
            try{
            $text=DB::table('send')->join('message','message.id','=','send.message_id')
            ->join('client','client.id','=','send.client_id')
            ->where('send.id',$request->id)
            ->select('message.message','client.client_phone')->first();
            $rand=mt_rand(1, 3);
            $randnumb=strval($rand);
            $payload=[
                'no'=>substr($text->client_phone,1),
                'text'=>$text->message,
                'index'=>$randnumb,
            ];
            dump($payload);
            $response=HTTP::post('http://localhost:8000/whatsapp/v1/cek',$payload)->json();
            if($response['status']=="00"){
                DB::table("send")
                ->where('id',$request->id)
                ->update(['status'=>'1']);
            }
            // $nomer="62".substr($text->client_phone,1)."@c.us";
            // $res = HTTP::asForm()->post('http://localhost:8000/send-message', [
            //         'number'=>$nomer,//"6289678971119@c.us",//substr($nomer[$i]->client_phone,1),
            //         // 'nomer'=>"62"."89678971119"."@c.us",//substr($text->client_phone,1),   
            //         'message'=>$text->message,
                
            // ]);
            
            // dump($nomer);
            // if($res['status']=="true"){
            //         DB::table("send")
            //         ->where('id',$request->id)
            //         ->update(['status'=>'1']);
            //     }
            // dump($res['status']);
            return $response;
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Maaf terjadi kesalahan',
                'additional message' => $e->getMessage()
            ], 409);
        }
            // if($response->status=="success"){
            //     DB::table("send")->update('status','1')->where('id',$request->id);
            // }
        }
        
    } catch (\Exception $e) {
        // if($response->status!="00"){
        return response()->json([
            'message' => 'Maaf terjadi kesalahan',
            'additional message' => $e->getMessage()
        ], 409);
        // }
    }
    }
}
