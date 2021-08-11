<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreQuestElement extends FormRequest
{
    use ApiRequest;

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
            'entity_id' => 'required|exists:entities,id',
            'description' => 'string',
            'role' => 'nullable|string|max:191',
            'colour' => 'nullable|string|max:10',
            'visibility' => 'nullable|string|max:10',
        ];

        return $this->clean($rules);
    }
}
