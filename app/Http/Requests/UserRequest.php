<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'username' => 'required',
        ];

        if ($this->getMethod() == 'POST'){
            $rules += [
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed'
            ];
        } else {
            $rules += [
                'email' => 'required|email|unique:users,email,'.$this->id,
                'password' => 'confirmed'
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'username.required' => 'Username is required',
            'email.required' => 'Email is required',
            'password.required' => 'Password is required',
        ];
    }
}
