<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEntityAbility extends FormRequest
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
            // 'ability_id' => 'required_without:abilities|exists:abilities,id',
            'abilities' => 'required:ability_id|array|min:1',
            'abilities.*' => 'distinct|exists:abilities,id',
            'position' => 'nullable|integer|min:0|max:100',
            'note' => 'nullable|string',
            'visibility_id' => 'nullable|exists:visibilities,id',
        ];
    }
}
