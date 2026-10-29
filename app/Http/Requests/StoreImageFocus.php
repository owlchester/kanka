<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImageFocus extends FormRequest
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
            'focus_x' => ['nullable', 'integer', 'min:0'],
            'focus_y' => ['nullable', 'integer', 'min:0'],
            'image_uuid' => ['nullable', 'string', 'uuid'],
        ];
    }
}
