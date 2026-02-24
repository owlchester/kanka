<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManageFamilies extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'character_family' => 'array',
            'character_family.*' => 'integer|exists:families,id',
            'family_privates' => 'array',
            'family_privates.*' => 'boolean',
        ];
    }
}
