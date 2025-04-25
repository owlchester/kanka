<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class PatchEntity extends FormRequest
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

    /*
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable|string|max:191',
            'entry' => 'nullable|string',
            'tooltip' => 'nullable|string',
            'image_uuid' => 'nullable|exists:images,id',
            'header_uuid' => 'nullable|exists:images,id',
            'type' => 'nullable|string|max:191',
        ];
    }
}
