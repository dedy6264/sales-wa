<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MerchantOutletRequest extends FormRequest
{
    public function rules()
    {
        return [
            'merchant_id'           =>'required',
            'merchant_outlet_name'  =>'required',
            'merchant_outlet_password'  =>'required',
            'merchant_outlet_repassword'  =>'required_with:merchant_outlet_password|same:merchant_outlet_password',
        ];
    }

    public function messages()
    {
        return [
            'merchant_id.required'          =>'Merchant Name canot be empty',
            'merchant_outlet_name.required' =>'Merchant Outlet Name canot be empty',
            'merchant_outlet_password.required' =>'Password Outlet Name canot be empty',
        ];
    }

}
