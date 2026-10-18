<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UserAltSubscribeStore extends FormRequest
{
    public function rules()
    {
        return [
            'method' => 'required|string|in:giropay,sofort,ideal',
            'period' => 'required|string|in:yearly',
            'accountholder-name' => 'required_if:method,giropay',
            'sofort-country' => 'required_if:method,sofort',
        ];
    }
}
