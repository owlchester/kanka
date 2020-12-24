<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuLink extends FormRequest
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
            'name' => 'required',
            'entity_id' => 'required_without_all:type,random_entity_type|exists:entities,id',
            'type' => 'required_without_all:entity_id,random_entity_type',
            'random_entity_type' => 'required_without_all:entity_id,type',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:' . auth()->user()->maxUploadSize(),
            'icon' => 'nullable',
            'tab' => 'nullable',
            'filters' => 'nullable|string|max:191',
            'menu' => 'nullable|string|max:45',
            'position' => 'nullable|integer|min:1|max:99'
        ];
    }
}
