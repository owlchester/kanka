<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserEnableTfa extends FormRequest
{
    public function rules()
    {
        return [
            'otp' => [
                'required',
                'numeric'
            ]
        ];
    }
}
