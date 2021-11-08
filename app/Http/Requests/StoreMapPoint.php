<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreMapPoint extends FormRequest
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
        return $this->clean([
            'target_entity_id' => 'integer|exists:entities,id|required_without_all:name',
            'name' => 'nullable|string|required_without_all:target_entity_id',
            'axis_x' => 'required|integer',
            'axis_y' => 'required|integer',
            'colour' => 'max:7',
            'size_id' => 'required|integer',
            'shape_id' => 'required|integer',
            'icon' => 'required',
        ]);
    }
}
