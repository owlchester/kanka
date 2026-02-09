<?php

namespace App\Http\Requests\Campaigns;

use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignApplication extends FormRequest
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
            'character_concept' => 'nullable|string|min:10',
            'experience'        => 'required|integer|in:0,1,2',
            'availability_days' => 'nullable|array',
            'availability_days.*' => 'string|in:mon,tue,wed,thu,fri,sat,sun',
            'time_start'        => 'nullable|date_format:H:i',
            'time_end'          => 'nullable|date_format:H:i',
            'timezone'          => 'nullable|string|max:100',
            'pref_rp_combat'    => 'required|integer|between:0,2',
            'pref_tone'         => 'required|integer|between:0,2',
            'external_link'     => 'nullable|url|max:255',
            'additional_notes'  => 'nullable|string|max:255',
        ];

        return $rules;
    }
}
