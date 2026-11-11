<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReorderCategoryStatuses extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('setting', $this->route('campaign')) ?? false;
    }

    public function rules(): array
    {
        return ['ids' => ['present', 'array', 'max:10'], 'ids.*' => ['required', 'integer', 'distinct']];
    }
}
