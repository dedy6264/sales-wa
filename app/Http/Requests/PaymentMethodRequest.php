<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentMethodRequest extends FormRequest
{
    
    public function messages()
    {
        return [
            'payment_method_name'	=> 'Method can not be empty',
            'description'			=> 'Please, describe your Method Payment',
        ];
    }

    
    public function rules()
    {
        return [
            'payment_method_name' =>'required',
            'description' =>'required',
        ];
    }
}
