<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMap extends FormRequest
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
            'name' => 'required',
            'type' => 'nullable|max:191',
            'map_id' => 'nullable|integer|exists:maps,id',
            'location_id' => 'nullable|integer|exists:locations,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:' . auth()->user()->maxUploadSize(false, 'map'),
            'image_url' => 'nullable|url|active_url',
            'template_id' => 'nullable|exists:attribute_templates,id',
            'center_x' => 'nullable|integer|min:0',
            'center_y' => 'nullable|integer|min:0',
        ];

        $self = request()->segment(5);
        if (!empty($self)) {
            $rules['map_id'] = 'nullable|integer|not_in:' . ((int) $self) . '|exists:maps,id';
        }

        return $rules;
    }
}
