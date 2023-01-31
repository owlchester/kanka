<?php

namespace App\Http\Requests\Campaigns;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GalleryImageStore extends FormRequest
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
        //opentype,ttf,woff,woff2 not working for some reason.
        $rules = [
            'file' => [
                '*' => [
                    'required', 'mimes:jpeg,jpg,gif,png,webp', 'max:' . auth()->user()->maxUploadSize()
                ],
            ],
            'folder_id' => [
                'nullable',
                Rule::exists('images', 'id')->where(function ($query) {
                    return $query->where('is_folder', 1);
                }),
            ],
        ];

        return $rules;
    }
}
