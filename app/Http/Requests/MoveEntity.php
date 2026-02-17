<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MoveEntity extends FormRequest
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
            'entities' => 'array|required',
            'entities.*' => 'distinct|integer|exists:entities,id',
            'campaign_id' => 'required|integer|exists:campaigns,id',
            'copy' => 'boolean',
        ];

        return $rules;
    }
}
