<?php

namespace App\Http\Requests\Campaigns;

use Illuminate\Foundation\Http\FormRequest;

class PatchCampaignApplication extends FormRequest
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
            'role_id' => 'required_if:action,approve:rejection|exists:campaign_roles,id',
            'reason' => 'nullable|string|max:191',
            'action' => 'required',
        ];
        return $rules;
    }
}
