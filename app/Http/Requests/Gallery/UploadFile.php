<?php

namespace App\Http\Requests\Gallery;

use App\Facades\Limit;
use App\Rules\GallerySize;
use Illuminate\Foundation\Http\FormRequest;

class UploadFile extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => [
                'mimes' => 'jpeg,png,jpg,gif,webp',
                'max' => Limit::upload(),
                new GallerySize(),
            ],
        ];
    }
}
