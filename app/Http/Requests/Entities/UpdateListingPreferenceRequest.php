<?php

namespace App\Http\Requests\Entities;

use Illuminate\Foundation\Http\FormRequest;

class UpdateListingPreferenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        if (! auth()->check()) {
            return false;
        }

        if ((int) $this->input('per_page') === 100 && ! auth()->user()->isSubscriber()) {
            return false;
        }

        return true;
    }

    public function rules(): array
    {
        return [
            'columns' => ['sometimes', 'array'],
            'columns.*' => ['string'],
            'layout' => ['sometimes', 'nullable', 'in:grid,table'],
            'nested' => ['sometimes', 'nullable', 'boolean'],
            'per_page' => ['sometimes', 'nullable', 'integer', 'in:15,25,45,100'],
        ];
    }
}
