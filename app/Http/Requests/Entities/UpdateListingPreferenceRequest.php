<?php

namespace App\Http\Requests\Entities;

use Illuminate\Foundation\Http\FormRequest;

class UpdateListingPreferenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'columns' => ['sometimes', 'array'],
            'columns.*' => ['string'],
            'layout' => ['sometimes', 'nullable', 'in:grid,table'],
            'nested' => ['sometimes', 'nullable', 'boolean'],
        ];
    }
}
