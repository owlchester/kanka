<?php

namespace App\Http\Requests\Gallery;

use App\Facades\Limit;
use App\Rules\GallerySize;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $types = ['jpeg', 'jpg', 'gif', 'png', 'webp'];
        $limit = Limit::campaign($this->route('campaign'));
        if ($this->user()) {
            $limit = $limit->user($this->user());
        }
        if (request()->has('map')) {
            $limit = $limit->map();
            $types[] = 'svg';
        }

        return [
            'file' => [
                'required',
                File::types($types),
                'max:' . $limit->upload(),
                new GallerySize,
            ],
        ];
    }
}
