<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MerchantRequest extends FormRequest
{
    public function rules()
    {
        return [
            'group_id'               => 'required',
            'village_id'             => 'required',
            'merchant_name'          => 'required',
            'merchant_nik'           => 'required',
            'merchant_address'       => 'required|max:255',
            'merchant_telp'          => 'required',
            'merchant_email'         => 'required',
            'merchant_date_of_birth' => 'required',
            'payment_method_id' => 'required',
            'merchant_account_number' => 'required',
            'segment_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'group_id.required'               => 'group_id can not be empty',
            'village_id.required'             => 'village_id can not be empty',
            'merchant_name.required'          => 'merchant_name can not be empty',
            'merchant_nik.required'           => 'merchant_nik can not be empty',
            'merchant_address.required'       => 'merchant_address can not be empty',
            'merchant_telp.required'          => 'merchant_telp can not be empty',
            'merchant_email.required'         => 'merchant_email can not be empty',
            'merchant_date_of_birth.required' => 'merchant_date_of_birth can not be empty',
            'payment_method_id' => 'payment_method_id can not be empty',
            'merchant_account_number' => 'merchant_account_number can not be empty',
            'segment_id' => 'segment_id can not be empty',
        ];
    }
}
