<?php

namespace App\Http\Requests;

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
        $type = request()->post('type');

        $rules = [
            'type' => 'required|in:email,link',
            'role_id' => 'required|exists:campaign_roles,id',
        ];

        if ($type == 'email') {
            $rules['email'] = 'required|email|unique:campaign_invites,email,NULL,id,campaign_id,'
                . Auth::user()->campaign->id.',is_active,1';
        } else {
            $rules['validity'] = 'nullable|integer';
        }

        return $rules;
    }
}
