<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillerProductTypesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function messages()
    {
        return [
            'product_type_name.required'=>'Type Name can not be empty',
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
            'product_type_name'=>'required',
        ];
    }
}
