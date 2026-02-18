<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShare extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'visibility_mode'    => ['nullable', 'string', 'in:entity,global'],
            'campaign_visibility' => ['nullable', 'string', 'in:public'],
        ];
    }
}
