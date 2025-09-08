<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class StoreClient extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:90'],
            'redirect' => ['required', 'string', 'max:120', 'url', 'active_url'],
        ];
    }
}
