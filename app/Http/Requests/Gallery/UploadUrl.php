<?php

namespace App\Http\Requests\Gallery;

use App\Models\Campaign;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UploadUrl extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var Campaign $campaign */
        $campaign = $this->route('campaign');

        return [
            'url' => 'required|string|url|active_url',
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
