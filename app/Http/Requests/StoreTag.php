<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTag extends FormRequest
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
        $colours = config('colours.keys');
        $rules = [
            'name' => 'required|max:191',
            'type' => 'nullable|string|max:191',
            'tag_id', 'nullable|integer|exists:tags,id',
            'image' => 'mimes:jpeg,png,jpg,gif,webp|max:' . auth()->user()->maxUploadSize(),
            'image_url' => 'nullable|url|active_url',
            'template_id' => 'nullable',
            'colour' => [
                'nullable',
                Rule::in($colours)
            ]
        ];

        $self = request()->segment(5);
        if (!empty($self)) {
            $rules['tag_id'] = 'integer|not_in:' . ((int) $self) . '|exists:tags,id';
        }

        return $this->clean($rules);
    }
}
