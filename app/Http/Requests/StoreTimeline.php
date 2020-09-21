<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTimeline extends FormRequest
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
            'calendar_id' => 'nullable|integer|exists:calendars,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:' . auth()->user()->maxUploadSize(false, 'map'),
            'image_url' => 'nullable|url|active_url',
            'template_id' => 'nullable|exists:attribute_templates,id',
            'revert_order' => 'nullable',
        ];

        return $rules;
    }
}
