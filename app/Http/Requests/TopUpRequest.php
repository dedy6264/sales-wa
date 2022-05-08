<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopUpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'account_id'                  => 'required',
            'account_transaction_type_id' => 'required',
            'ammount'                     => 'required',
            'num_reff'                    => 'required',
        ];
    }

    public function messages()
    {
        return [
            'account_id.required'                  => 'Account ID can not be empty',
            'account_transaction_type_id.required' => 'Account Transaction Type ID can not be empty',
            'ammount.required'                     => 'Ammount can not be empty',
            'num_reff.required'                    => 'Refference number can not be empty',
           
        ];
    }
}
