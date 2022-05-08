<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SegmentRequest extends FormRequest
{
    
    public function messages()
    {
        return [
            'segment_name.required'  =>'Segment Name can not be empty',
        ];
    }

    
    public function rules()
    {
        return [
            'segment_name'=>'required',
        ];
    }
}
