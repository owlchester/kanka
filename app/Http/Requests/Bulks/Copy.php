<?php

namespace App\Http\Requests\Bulks;

use Illuminate\Foundation\Http\FormRequest;

class Copy extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'models' => 'required_without:entities|string',
            'entities' => 'required_without:models|array',
            'entities.*' => 'integer',
            'campaign' => 'required|integer|exists:campaigns,id',
        ];
    }
}
