<?php

namespace App\Http\Requests;

use App\Facades\Limit;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEntityImage extends FormRequest
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
            'image' => 'required_without_all:image_url,entity_image_uuid|mimes:jpeg,png,jpg,gif,webp|max:' . Limit::upload(),
            'image_url' => 'required_without_all:image,entity_image_uuid|nullable|url',
            'entity_image_uuid' => 'required_without_all:image_url,image|exists:images,id',
        ];

        return $rules;
    }
}
