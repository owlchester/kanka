<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteCategoryStatus extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('setting', $this->route('campaign')) ?? false;
    }

    public function rules(): array
    {
        return [
            'replacement_id' => ['nullable', 'integer'],
            'clear' => ['sometimes', 'boolean'],
        ];
    }
}
