<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateModuleName extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'enabled' => 'nullable|boolean',
            'singular' => 'nullable|string|max:45',
            'plural' => 'nullable|string|max:45',
            'icon' => 'nullable|string|max:60',
        ];
    }
}
