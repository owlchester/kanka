<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreTimeline extends FormRequest
{
    use ApiRequest;

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
            'timeline_id', 'nullable|integer|exists:timelines,id',
            'calendar_id' => 'nullable|integer|exists:calendars,id',
            'image' => 'mimes:jpeg,png,jpg,gif,webp,svg|max:' . auth()->user()->maxUploadSize(false, 'map'),
            'image_url' => 'nullable|url|active_url',
            'template_id' => 'nullable',
            'revert_order' => 'nullable',
        ];

        return $this->clean($rules);
    }
}
