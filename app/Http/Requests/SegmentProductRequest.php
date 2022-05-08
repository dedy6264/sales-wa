<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SegmentProductRequest extends FormRequest
{
   
    public function messages()
    {
        return [
                    'segment_id.required'  =>'segment_id can not be empty',
                    'product_id.required'  =>'product_id can not be empty',
                    'product_price.required'  =>'product_price can not be empty',
                    'product_admin_fee.required'  =>'product_admin_fee can not be empty',
                    'product_merchant_fee.required'  =>'product_merchant_fee can not be empty',
                    'product_role_assign_provider.required'  =>'product_role_assign_provider can not be empty',
                    'product_role_multi_provider.required'  =>'product_role_multi_provider can not be empty',
        ];
    }

    
    public function rules()
    {
        return [
                    'segment_id' =>'required',
                    'product_id' =>'required',
                    'product_price' =>'required',
                    'product_admin_fee' =>'required',
                    'product_merchant_fee' =>'required',
                    'product_role_assign_provider' =>'required',
                    'product_role_multi_provider' =>'required',
        ];
    }
}
