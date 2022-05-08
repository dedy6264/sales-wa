<?php

namespace App\Http\Controllers;
use App\Http\Requests\SegmentProductRequest;
use App\Models\{SegmentProduct,Segment};
use Illuminate\Http\Request;
use DB;
class SegmentProductController extends Controller
{
    
    public function index()
    {
        $listSegment = Segment::get(['id', 'segment_name']);
        $listSegment->prepend([
            'id' => -1,
            'segment_name' => 'ALL Segment'
        ]);
        // $segment=DB::table('segment')->get(['id','segment_name']);
        $product=DB::table('product')->get(['id','product_name']);
        $provider=DB::table('provider')->get(['id','provider_name']);
         return view('contents.segment_product.index', compact('product','provider','listSegment'));
    }
    public function getFilterData(Request $request)
    {
        $segment_id = $request->filter['segment_id_filter'];
        return DB::table('segment_product')->join('segment','segment.id','=','segment_product.segment_id')
            ->join('product','product.id','=','segment_product.product_id')
            ->join('provider','provider.id','=','segment_product.product_role_assign_provider')
            ->select(   'segment_product.*',
                    'segment.segment_name',
                    'product.product_name',
                    'provider.provider_name')
            ->when($segment_id, function ($query, $segment_id) {
                if ($segment_id != -1) return $query->where('segment_id', $segment_id);
            })
            ->orderBy('created_at','desc')
            ->get();
    }
    public function all(Request $request)
    {
        $mainData = $this->getFilterData($request);
        return datatables()->of($mainData)
            ->addIndexColumn()
            ->make();
    }
    public function store(SegmentProductRequest $request)
    {
        SegmentProduct::create($request->validated());
        return true;
    }
    public function update(SegmentProductRequest $request, SegmentProduct $segmentProduct)
    {
        $segmentProduct->update($request->validated());
        return true;
    }
    public function destroy(SegmentProduct $segmentProduct)
    {
        $segmentProduct->delete();
        return true;
    }
}
