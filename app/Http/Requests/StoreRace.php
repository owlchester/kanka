<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRace extends FormRequest
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
            'name' => 'required',
            'race_id' => 'nullable|integer|exists:races,id',
            'image' => 'mimes:jpeg,png,jpg,gif,webp|max:' . auth()->user()->maxUploadSize(),
            'image_url' => 'nullable|url|active_url',
            'template_id' => 'nullable',
        ];

        $self = request()->segment(5);
        if (!empty($self)) {
            $rules['race_id'] = 'nullable|integer|not_in:' . ((int) $self) . '|exists:races,id';
        }

        return $rules;
    }
}
