<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function messages()
    {
        return [
            'client_name'=>'Client Name can not be empty',
            'client_address'=>'Client Name can not be empty',
            'client_phone'=>'Client Name can not be empty',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client_name'=>'required',
            'client_address'=>'required',
            'client_phone'=>'required',
        ];
    }
}
