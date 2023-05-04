<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UserSubscribePayPal extends FormRequest
{
    public function rules()
    {
        return [
            'tier' => 'required',
        ];
    }
}
