<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillerProviderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function messages()
    {
        return [
            'provider_name.required'=>'Provider Name can not be empty',
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
            'provider_name'=>'required',
        ];
    }
}
