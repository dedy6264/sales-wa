<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillerProductProviderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function messages()
    {
        return [
            'provider_id.required'=>'Provider can not be empty',
            'product_id.required'=>'Product can not be empty',
            'product_provider_code.required'=>'Provider Code can not be empty',
            'product_provider_name.required'=>'Provider Name can not be empty',
            'product_provider_index.unique'=>'Provider has been created',
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
            'product_provider_index'=>$this->id ? 'unique:product_provider,product_provider_index,'.$this->id : 'unique:product_provider,product_provider_index',
            'product_id'=>'required',
            'provider_id'=>'required',
            'product_provider_code'=>'required',
            'product_provider_name'=>'required',
            'product_provider_price'=>'required',
            'product_provider_admin_fee'=>'required',
            'product_provider_merchant_fee'=>'required',
            'product_provider_env_method'=>'required',
        ];
    }
}
