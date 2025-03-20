<?php

namespace App\Http\Requests;

use App\Facades\CampaignLocalization;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PermissionTestRequest extends FormRequest
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
            '*.entity_id' => 'required_without:*.entity_type_id|integer|exists:entities,id',
            '*.entity_type_id' => 'required_without:*.entity_id|integer|exists:entity_types,id',
            '*.action' => 'required|integer|exists:campaign_permissions,action',
            // '*.user_id' => 'required|integer|exists:campaign_user,user_id',
            '*.user_id' => [
                'required',
                'integer',
                Rule::exists('campaign_user')->where(function ($query) {
                    $query->where('user_id', $this->input('*.user_id'))->where('campaign_id', CampaignLocalization::getCampaign()->id);
                }),
            ],
        ];
    }
}
