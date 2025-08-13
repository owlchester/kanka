<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class StoreApiToken extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:90'],
        ];
    }
}
