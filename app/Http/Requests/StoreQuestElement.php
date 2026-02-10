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
            'entity_id' => 'nullable|required_without:name|exists:entities,id',
            'name' => 'nullable|string|required_without:entity_id',
            'entry' => 'string|nullable',
            'role' => 'nullable|string|max:191',
            'colour' => 'nullable|string|max:10',
            'visibility_id' => 'nullable|exists:visibilities,id',
        ];

        return $this->clean($rules);
    }
}
