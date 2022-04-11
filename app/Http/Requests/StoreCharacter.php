<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreCharacter extends FormRequest
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
            'image' => 'mimes:jpeg,png,jpg,gif,webp|max:' . auth()->user()->maxUploadSize(),
            'image_url' => 'nullable|url|active_url',
            'location_id' => 'integer|exists:locations,id',
            'age' => 'nullable|max:25',
            'sex' => 'nullable|max:45',
            'pronouns' => 'nullable|max:45',
            'title' => 'nullable|max:191',
            'template_id' => 'nullable',
            'families' => 'array',
            'families.*' => 'distinct|exists:families,id',
            'races' => 'array',
            'races.*' => 'distinct|exists:races,id'
        ];

        return $this->clean($rules);
    }
}
