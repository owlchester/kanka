<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttributeTemplate extends FormRequest
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
            'name' => 'required|max:191',
            'attribute_template_id' => 'nullable|integer|exists:attribute_templates,id',
            'entity_type_id' => 'nullable|integer|exists:entity_types,id',
        ];

        // Editing an attribute template? Don't allow selecting oneself.
        $self = request()->segment(5);
        if (!empty($self)) {
            $rules['attribute_template_id'] = 'integer|not_in:' . ((int) $self) . '|exists:attribute_templates,id';
        }

        return $rules;
    }
}
