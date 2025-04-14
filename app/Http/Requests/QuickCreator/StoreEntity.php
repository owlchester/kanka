<?php

namespace App\Http\Requests\QuickCreator;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEntity extends FormRequest
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
            'name' => 'required|string',
            'template_id' => [
                'integer',
                Rule::exists('entities', 'id')->where(function ($query) {
                    return $query->where('is_template', true);
                })
            ]
        ];
    }
}
