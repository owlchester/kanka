<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCharacter extends FormRequest
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
            'name' => 'required|max:191',
            'age' => 'nullable|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:8192',
            'family_id' => 'integer|exists:families,id',
            'location_id' => 'integer|exists:locations,id'
        ];
    }
}
