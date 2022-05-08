<?php

namespace App\Http\Controllers;

use App\Models\{Message,Send,Client};
use Illuminate\Http\Request;
use App\Http\Requests\MessageRequest;
use DB;

class MessageController extends Controller
{
    public function index()
    {
        return view('contents.message.index');
    }
    public function all(Request $request)
    {
        $mainData = Message::select('*')->get();
        return datatables()->of($mainData)
            ->addIndexColumn()
            // ->editColumn('created_at', function($item){
            //     return Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('Y-m-d H:i:s');
            // })
            // ->editColumn('updated_at', function($item){
            //     return Carbon::createFromFormat('Y-m-d H:i:s', $item->updated_at)->format('Y-m-d H:i:s');
            // })
            ->make();
    }
    public function store(MessageRequest $request)
    {
        Message::create($request->validated());
        return true;
    }
    public function setAll(int $id)
    {
        $max=DB::table('client')->select(DB::raw('count(id)'))->first();
// dd($max);
        $mainData = Client::select('*')->get();
        dump($id);
        dump($mainData[0]->id);
        // dd($mainData['']);
        for($i=0;$i<$max->count;$i++){
            $payload=[
                // 'id'=>$request->id,
                'message_id'=>$id,
                'client_id'=>$mainData[$i]->id,
                'broadcast_type_id'=>0,
                'status'=>0,
                'index'=>$id.$mainData[$i]->id,
            ];
            Send::create($payload);
        }
        // Send::create();
        return true;
    }
    public function update(MessageRequest $request, Message $message)
    {
        $message->update($request->validated());
        return true;
    }
    public function destroy(Message $message)
    {
        $message->delete();
        return true;
    }
}
