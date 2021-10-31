<?php

namespace App\Http\Requests;

use App\Models\CampaignInvite;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCampaignInvite extends FormRequest
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
        $typeID = request()->post('type_id');

        $rules = [
            'type' => 'required|in:email,link',
            'role_id' => 'required|exists:campaign_roles,id',
        ];

        if ($typeID == CampaignInvite::TYPE_EMAIL) {
            $rules['email'] = 'required|email|unique:campaign_invites,email,NULL,id,campaign_id,'
                . auth()->user()->campaign->id.',is_active,1';
        } else {
            $rules['validity'] = 'nullable|integer';
        }

        return $rules;
    }
}
