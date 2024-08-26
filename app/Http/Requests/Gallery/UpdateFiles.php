<?php

namespace App\Http\Requests\Gallery;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFiles extends FormRequest
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
            'files' => 'required|array',
            'images.*' => 'distinct|exists:images,id',
            'visibility_id' => 'nullable|integer|exists:visibilities,id',
            'folder_id' => 'nullable|string|exists:images,id',
            'folder_home' => 'nullable'
        ];
    }
}
