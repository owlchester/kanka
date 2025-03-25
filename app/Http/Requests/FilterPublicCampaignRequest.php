<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterPublicCampaignRequest extends FormRequest
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
        return [
            'sort_field_name' => 'integer|max:2',
            'is_boosted' => 'nullable|boolean',
            'featured_until' => 'nullable|boolean',
            'is_open' => 'nullable|boolean',
            'system' => 'nullable|string|max:25',
            'language' => 'nullable|string|max:5',
            'genre' => 'nullable|integer',
        ];
    }
}
