<?php

namespace App\Http\Requests\Campaigns;

use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignSetup extends FormRequest
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
            'locale' => 'nullable|string|max:10',
            'systems' => 'nullable|array',
            'systems.*' => 'exists:game_systems,id',
            'campaign_genre' => 'nullable|integer',
            'genres' => 'nullable|array',
            'genres.*' => 'exists:genres,id',
            'intro' => 'nullable|string|max:2000',
            'timezone' => 'nullable|string|max:45',
            'schedule' => 'nullable|string|max:45',
            'players' => 'nullable|string|max:45',
            'playstyles' => 'array',
            'playstyles.*' => 'exists:playstyles,id',
            'is_prioritised' => 'nullable|boolean',
        ];
    }
}
