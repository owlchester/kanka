<?php

namespace App\Http\Requests\Gallery;

use App\Models\Campaign;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeleteImages extends FormRequest
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
            'images' => 'required|array',
            'images.*' => [
                'required',
                'string',
                'distinct',
                Rule::exists('images', 'id')->where('campaign_id', $campaign->id),
            ],
        ];
    }
}
