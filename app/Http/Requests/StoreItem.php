<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreItem extends FormRequest
{
    use ApiRequest;

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
            'name' => 'required|max:191',
            'type' => 'nullable|max:191',
            'location_id' => 'nullable|numeric|exists:locations,id',
            'character_id' => 'nullable|numeric|exists:characters,id',
            'image' => 'mimes:jpeg,png,jpg,gif,webp|max:' . auth()->user()->maxUploadSize(),
            'image_url' => 'nullable|url|active_url',
            'template_id' => 'nullable',
            'price' => 'nullable|string|max:191',
            'size' => 'nullable|string|max:191',
        ];
        return $this->clean($rules);
    }
}
