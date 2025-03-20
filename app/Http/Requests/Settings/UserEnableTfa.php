<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UserEnableTfa extends FormRequest
{
    public function rules()
    {
        return [
            'otp' => [
                'required',
                'numeric',
            ],
        ];
    }
}
