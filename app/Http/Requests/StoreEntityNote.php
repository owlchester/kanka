<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEntityNote extends FormRequest
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
            'visibility' => 'required',
            'is_pinned' => 'boolean',
            'position' => 'nullable|integer|min:0|max:128',
            'entry' => '',
        ];
    }
}
