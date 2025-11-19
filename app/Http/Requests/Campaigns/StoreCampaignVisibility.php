<?php

namespace App\Http\Requests\Campaigns;

use App\Enums\CampaignVisibility;
use App\Enums\Widget;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreCampaignVisibility extends FormRequest
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
            'visibility_id' => ['required', new Enum(CampaignVisibility::class)]
        ];

        return $rules;
    }
}
