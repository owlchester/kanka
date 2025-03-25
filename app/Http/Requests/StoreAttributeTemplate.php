<?php

namespace App\Http\Requests;

use App\Models\AttributeTemplate;
use App\Rules\Nested;
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
        /** @var AttributeTemplate $self */
        $self = request()->route('attribute_template');
        if (! empty($self)) {
            $rules['attribute_template_id'] = [
                'nullable',
                'integer',
                'exists:attribute_templates,id',
                new Nested(AttributeTemplate::class, $self),
            ];
        }

        return $rules;
    }
}
