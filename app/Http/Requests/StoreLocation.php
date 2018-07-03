<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocation extends FormRequest
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
            'type' => 'max:45',
            'parent_location_id', 'integer|exists:locations,id',
            'section_id' => 'integer|exists:sections,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:8192',
            'image_url' => 'nullable|url|active_url',
            'template_id' => 'exists:attribute_templates,id',
        ];

        $self = request()->segment(3);
        if (!empty($self)) {
            $rules['parent_location_id'] = 'integer|not_in:' . ((int) $self) . '|exists:locations,id';
        }

        return $rules;
    }
}
