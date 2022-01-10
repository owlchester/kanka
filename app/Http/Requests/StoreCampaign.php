<?php

namespace App\Http\Requests;

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
            'image' => 'mimes:jpeg,png,jpg,gif,webp|max:' . auth()->user()->maxUploadSize(),
            'header_image' => 'mimes:jpeg,png,jpg,gif,webp|max:' . auth()->user()->maxUploadSize(),
            'locale' => 'nullable|string',
            'system' => 'nullable|string',
            'entity_visibility' => 'nullable',
            'entity_personality_visibility' => 'nullable',
            'is_public' => 'nullable',
            'css' =>  'nullable|string',
            'theme_id' => 'nullable|exists:themes,id'
        ];

        if (request()->is('api/*') && !request()->isMethod('POST')) {
            $rules['name'] = 'string|min:4';
        }

        return $rules;
    }
}
