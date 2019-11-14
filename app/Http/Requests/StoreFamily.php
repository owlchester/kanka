<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFamily extends FormRequest
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
            'type' => 'nullable:max:191',
            'location_id' => 'nullable|integer|exists:locations,id',
            'family_id' => 'nullable|exists:families,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:' . auth()->user()->maxUploadSize(),
            'image_url' => 'nullable|url|active_url',
            'template_id' => 'nullable|exists:attribute_templates,id',
        ];

        $self = request()->segment(5);
        if (!empty($self)) {
            $rules['family_id'] = 'nullable|integer|not_in:' . ((int) $self) . '|exists:families,id';
        }

        return $rules;
    }
}
