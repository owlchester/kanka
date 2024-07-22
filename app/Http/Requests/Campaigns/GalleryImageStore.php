<?php

namespace App\Http\Requests\Campaigns;

use App\Facades\Limit;
use App\Rules\GallerySize;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

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
            'file' => 'required|array',
            'file.*' => [
                File::types(['jpeg', 'jpg', 'gif', 'png', 'webp', 'woff2', '.svg']),
                'max:' . Limit::upload(),
                new GallerySize(),
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
