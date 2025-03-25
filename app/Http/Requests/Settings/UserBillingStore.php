<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserBillingStore extends FormRequest
{
    public function rules()
    {
        return [
            'currency' => [
                'nullable',
                Rule::in(['usd', 'eur', 'brl']),
            ],
        ];
    }
}
