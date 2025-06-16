<?php

namespace App\Http\Requests;

use App\Facades\Domain;
use App\Facades\Limit;
use Illuminate\Foundation\Http\FormRequest;

class StoreCampaign extends FormRequest
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
            'name' => 'required|string|min:4',
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
        ];

        if ((Domain::isApi()) && ! request()->isMethod('POST')) {
            $rules['name'] = 'string|min:4';
        }

        return $rules;
    }
}
