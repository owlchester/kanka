<?php

namespace App\Http\Requests\Campaigns;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class GalleryImageUpdate extends FormRequest
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
            'images.*' => [
                'required',
                File::types(['jpeg', 'jpg', 'gif', 'png', 'webp', 'woff2']),
                'max:' . auth()->user()->maxUploadSize()
            ],
            'name' => 'required|max:45',
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
