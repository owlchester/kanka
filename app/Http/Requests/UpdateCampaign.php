<?php

namespace App\Http\Requests;

use App\Facades\Limit;
use App\Rules\Vanity;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCampaign extends FormRequest
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
            'name' => 'string|min:4',
            'vanity' => ['nullable', 'string', 'min:4', 'max:45', 'unique:campaigns,slug', new Vanity],
            'entry' => 'nullable|string',
            'image' => 'mimes:jpeg,png,jpg,gif,webp|max:' . Limit::upload(),
            'header_image' => 'mimes:jpeg,png,jpg,gif,webp|max:' . Limit::upload(),
            'locale' => 'nullable|string',
            'systems' => 'array',
            'systems.*' => 'distinct|exists:game_systems,id',
            'entity_visibility' => 'nullable',
            'entity_personality_visibility' => 'nullable',
            'is_public' => 'nullable',
            'css' => 'nullable|string',
            'theme_id' => 'nullable|exists:themes,id',
            'genres' => 'array',
            'genres.*' => 'distinct|exists:genres,id',
        ];

        return $rules;
    }
}
