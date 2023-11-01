<?php

namespace App\Http\Requests\API;

use App\Facades\Limit;
use Illuminate\Foundation\Http\FormRequest;

class UploadEntityImage extends FormRequest
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
            'image' => 'required|mimes:jpeg,png,jpg,gif,webp|max:' . Limit::upload(),
        ];
    }
}
