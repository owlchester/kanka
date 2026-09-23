<?php

namespace App\Http\Requests\Gallery;

use App\Facades\Limit;
use App\Models\Campaign;
use App\Rules\GallerySize;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UploadFiles extends FormRequest
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
     */
    public function rules(): array
    {
        /** @var Campaign $campaign */
        $campaign = $this->route('campaign');
        $types = ['jpeg', 'jpg', 'gif', 'png', 'webp', 'woff2'];

        return [
            'files' => 'required|array',
            'files.*' => [
                'required',
                File::types($types),
                'max:' . Limit::upload(),
                new GallerySize,
            ],
            'folder_id' => [
                'nullable',
                'string',
                Rule::exists('images', 'id')
                    ->where('is_folder', true)
                    ->where('campaign_id', $campaign->id),
            ],
        ];
    }
}
