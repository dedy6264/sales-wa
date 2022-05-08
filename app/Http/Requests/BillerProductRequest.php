<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillerProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function messages()
    {
        return [
            'product_type_id.required' => 'Product Type can not be empty',
            'product_category_id.required' => 'Product Category can not be empty',
            'product_unit_name.required' => 'Product Unit Name can not be empty',
            'product_code.required' => 'Product Code can not be empty',
            'product_name.required' => 'Product Name can not be empty',
            
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
            'product_type_id'=>'required',
            'product_category_id'=>'required',
            'product_unit_name'=>'required',
            'product_code'=>'required',
            'product_name'=>'required',
           
        ];
    }
}
