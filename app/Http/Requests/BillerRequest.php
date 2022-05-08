<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function messages()
    {
        return [
            'client_name.required'=>'Client Name can not be empty',
            'region_name.required'=>'Region Name can not be empty',
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
            'region_name'=>'required',
        ];
    }
}
