<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWebhook extends FormRequest
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
            'action' => 'integer|required',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
            'url' => 'string|required|active_url|max:191',
            'type' => 'required|integer',
            'message' => 'required_if:type_id,1',
            'status' => 'nullable|boolean',
        ];
    }
}
