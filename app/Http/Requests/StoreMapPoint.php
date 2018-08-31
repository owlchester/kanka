<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMapPoint extends FormRequest
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
            'target_id' => 'integer|exists:locations,id|required_without_all:name',
            'name' => 'nullable|string|required_without_all:target_id',
            'axis_x' => 'required|integer',
            'axis_y' => 'required|integer',
            'colour' => 'required',
        ];
    }
}
