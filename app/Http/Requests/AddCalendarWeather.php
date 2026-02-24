<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCalendarWeather extends FormRequest
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
            'weather' => 'required',
            'temperature' => 'nullable',
            'precipitation' => 'nullable',
            'wind' => 'nullable',
            'effect' => 'nullable',
            'day' => 'required',
            'month' => 'required',
            'year' => 'required',
            'name' => 'nullable|string|max:40',
            'visibility_id' => 'nullable|integer|exists:visibilities,id',
        ];
    }
}
