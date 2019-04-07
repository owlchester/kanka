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
            'parent_location_id', 'nullable|integer|exists:locations,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:' . auth()->user()->maxUploadSize(),
            'image_url' => 'nullable|url|active_url',
            'map' => 'image|mimes:jpeg,png,jpg,gif,svg|max:' . auth()->user()->maxUploadSize(false, 'map'),
            'map_url' => 'nullable|url|active_url',
            'template_id' => 'nullable|exists:attribute_templates,id',
        ];

        $self = request()->segment(5);
        if (!empty($self)) {
            $rules['parent_location_id'] = 'integer|not_in:' . ((int) $self) . '|exists:locations,id';
        }

        return $rules;
    }
}
