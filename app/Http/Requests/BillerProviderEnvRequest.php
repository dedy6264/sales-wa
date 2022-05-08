<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillerProviderEnvRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function messages()
    {
        return [
                'provider_id.unique'=>'provider_id can not be empty',
                'provider_payment_env_code.required'=>'provider_payment_env_code can not be empty',
                'provider_payment_env_name.required'=>'provider_payment_env_name can not be empty',
                'provider_payment_env_value_id.required'=>'provider_payment_env_value_id can not be empty',
                'provider_payment_env_value_support.required'=>'provider_payment_env_value_support can not be empty',
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
            'provider_id'=> $this->id ? 'required:unique,provider_payment_env,'.$this->id : 'required:unique,provider_payment_env',
            'provider_payment_env_code'=>'required',
            'provider_payment_env_name'=>'required',
            'provider_payment_env_value_id'=>'required',
            'provider_payment_env_value_support'=>'required',
        ];
    }
}
