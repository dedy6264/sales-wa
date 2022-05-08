<?php

namespace App\Http\Controllers;
use App\Http\Requests\PaymentMethodRequest;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{public function index()
    {
        return view('contents.payment_method.index');
    }
    public function all()
    {
        $mainData = PaymentMethod::select('*')->get();
        return datatables()->of($mainData)
            ->addIndexColumn()
            ->make();
    }
    public function store(PaymentMethodRequest $request)
    {
        PaymentMethod::create($request->validated());
        return true;
    }
    public function update(PaymentMethodRequest $request, PaymentMethod $paymentMethod)
    {
        $paymentMethod->update($request->validated());
        return true;
    }
    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();
        return true;
    }
}
