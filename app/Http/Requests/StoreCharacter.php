<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCharacter extends FormRequest
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
        return [
            'name' => 'required|max:191',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:8192',
            'family_id' => 'integer|exists:families,id',
            'location_id' => 'integer|exists:locations,id',
            'section_id' => 'nullable|integer|exists:sections,id',
            'race_id' => 'nullable|integer|exists:race,id',
            'age' => 'nullable|max:25',
            'height' => 'nullable|max:10',
            'weight' => 'nullable|max:10',
            'sex' => 'nullable|max:45',
            'eye_colour' => 'nullable|max:12',
            'hair' => 'nullable|max:45',
            'skin' => 'nullable|max:45',
            'title' => 'nullable|max:191',
            'languages' => 'nullable|max:191',
            'image_url' => 'nullable|url|active_url',
            'template_id' => 'nullable|exists:attribute_templates,id',
        ];
    }
}
