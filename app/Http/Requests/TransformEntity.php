<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransformEntity extends FormRequest
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
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'entities' => 'array|required',
            'entities.*' => 'distinct|integer|exists:entities,id',
            'entity_type' => 'required|integer|exists:entity_types,id',
        ];

        return $rules;
    }
}
