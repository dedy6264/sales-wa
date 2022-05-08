<?php

namespace App\Http\Controllers;
use App\Http\Requests\SegmentRequest;
use App\Models\{Segment,SegmentProduct};
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class SegmentController extends Controller
{
    public function index()
    {
        return view('contents.segment.index');
    }
    public function all()
    {
        $mainData = Segment::select('*')->get();
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
    public function store(SegmentRequest $request)
    {
        Segment::create($request->validated());
        return true;
    }
    public function update(SegmentRequest $request, Segment $segment)
    {
        $segment->update($request->validated());
        return true;
    }
    public function destroy(Segment $segment)
    {
        $segment->delete();
        return true;
    }

    public function duplicate(int $id)
    {
        $segment=Segment::where('id',$id)->first();
        // $payload=[
        //     "segment_name"=>$segment->segment_name."copy"
        // ];
        // Segment::create($payload);
        $lastID = Segment::insertGetId(array(
            "segment_name"=>$segment->segment_name." copy",
            "created_at"=> Carbon::now(),
            "updated_at"=> Carbon::now(),
            "created_by"=> auth()->user()->username,
         ));

        $resx=DB::table('segment_product')->where('segment_id',$id)->get();
        $datachild		= array();
        foreach ($resx as $op)
        {
            $row	= array();
            $row	= [
                'segment_id'	                    =>	$lastID,
                'product_id'	                    =>	$op->product_id,
                'product_price'	                    =>	$op->product_price,
                'product_admin_fee'		            =>	$op->product_admin_fee,
                'product_merchant_fee'			    =>	$op->product_merchant_fee,
                'product_role_assign_provider'		=>	$op->product_role_assign_provider,
                'product_role_multi_provider'		=>	$op->product_role_multi_provider,
                "created_at"                        =>  Carbon::now(),
                "updated_at"                        =>  Carbon::now(),
                "created_by"                        =>  auth()->user()->username,
            ];
                $datachild[] = $row;
        }
        DB::table('segment_product')->insert($datachild);
    return true;
    }
}
