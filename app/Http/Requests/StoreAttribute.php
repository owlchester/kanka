<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttribute extends FormRequest
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
            'entity_id' => 'required|exists:entities,id',
            'name' => 'required|max:191',
            'value' => 'nullable|string',
            'type' => 'nullable|string',
            'api_key' => 'nullable|string|max:20'
        ];
    }
}
