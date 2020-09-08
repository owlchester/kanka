<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNote extends FormRequest
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
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:' . auth()->user()->maxUploadSize(),
            'image_url' => 'nullable|url|active_url',
            'template_id' => 'nullable|exists:attribute_templates,id',
            'note_id' => 'nullable|integer|exists:notes,id',
        ];
        $self = request()->segment(5);
        if (!empty($self)) {
            $rules['note_id'] = 'integer|not_in:' . ((int) $self) . '|exists:notes,id';
        }

        return $rules;
    }
}
