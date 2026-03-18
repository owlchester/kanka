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
            'per_page' => ['sometimes', 'nullable', 'integer', 'in:10,25,50,100'],
        ];
    }

    public function withValidator(\Illuminate\Validation\Validator $validator): void
    {
        $validator->after(function (\Illuminate\Validation\Validator $v) {
            if ((int) $this->input('per_page') === 100 && ! auth()->user()?->isSubscriber()) {
                abort(403, 'Subscription required for 100 results per page.');
            }
        });
    }
}
