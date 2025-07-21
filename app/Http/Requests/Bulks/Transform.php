<?php

namespace App\Http\Requests\Bulks;

use Illuminate\Foundation\Http\FormRequest;

class Transform extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'target' => 'required|exists:entity_types,id',
        ];
    }
}
