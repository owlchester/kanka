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
        $rules = [
            'name' => 'required|max:191',
            'type' => 'nullable|max:191',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:' . auth()->user()->maxUploadSize(),
            'location_id' => 'nullable|integer|exists:locations,id',
            'organisation_id' => 'nullable|exists:organisations,id',
            'image_url' => 'nullable|url|active_url',
            'template_id' => 'nullable|exists:attribute_templates,id',
        ];

        $self = request()->segment(5);
        if (!empty($self)) {
            $rules['organisation_id'] = 'nullable|integer|not_in:' . ((int) $self) . '|exists:organisations,id';
        }

        return $rules;
    }
}
