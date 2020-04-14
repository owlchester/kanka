<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAbility extends FormRequest
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
            'name' => 'required',
            'type' => 'nullable:max:191',
            'ability_id' => 'nullable|integer|exists:abilities,id',
            'charges' => 'nullable|max:120',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:' . auth()->user()->maxUploadSize(),
            'image_url' => 'nullable|url|active_url',
            'template_id' => 'nullable|exists:attribute_templates,id',
        ];

        $self = request()->segment(5);
        if (!empty($self)) {
            $rules['ability_id'] = 'nullable|integer|not_in:' . ((int) $self) . '|exists:abilities,id';
        }

        return $rules;
    }
}
