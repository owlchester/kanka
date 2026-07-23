<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMapPreset extends FormRequest
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
            'name' => 'required|string|max:191',
            'shape' => ['nullable', 'string', Rule::in(['marker', 'label', 'circle', 'poly', 'path'])],
            'colour' => 'nullable|string|max:20',
            'icon' => 'nullable|integer',
            'custom_icon' => 'nullable|string|max:191',
            'opacity' => 'nullable|integer|min:0|max:100',
            'is_draggable' => 'boolean',
            'css' => 'nullable|string|max:45',
        ];

        return $this->clean($rules);
    }
}
