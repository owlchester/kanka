<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrganisation extends FormRequest
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
            'type' => 'max:191',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:8192',
            'location_id' => 'integer|exists:locations,id',
            'section_id' => 'integer|exists:sections,id',
            'image_url' => 'nullable|url|active_url',
        ];
    }
}
