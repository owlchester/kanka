<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestOrganisation extends FormRequest
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
            'quest_id' => 'required|exists:quests,id',
            'organisation_id' => 'required|exists:organisations,id',
            'description' => '',
            'role' => 'nullable|string|max:45',
        ];
    }
}
