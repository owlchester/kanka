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
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:' . auth()->user()->maxUploadSize(),
            'image_url' => 'nullable|url|active_url',
            'family_id' => 'integer|exists:families,id',
            'location_id' => 'integer|exists:locations,id',
            'race_id' => 'nullable|integer|exists:races,id',
            'age' => 'nullable|max:25',
            'sex' => 'nullable|max:45',
            'title' => 'nullable|max:191',
            'template_id' => 'nullable|exists:attribute_templates,id',
        ];
    }
}
