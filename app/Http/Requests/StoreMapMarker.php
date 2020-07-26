<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class StoreMapMarker extends FormRequest
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
            'name' => 'nullable|string',
            'entry' => 'nullable|string',
            'visibility' => 'string',
            'entity_id' => 'integer|exists:entities,id|required_without_all:name',
            'group_id' => 'nullable|integer|exists:map_groups,id',

            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'colour' => 'max:7',
            'size_id' => 'nullable|integer',

            'shape_id' => 'required|integer',
            'custom_shape' => 'nullable|string',

            'icon' => 'required|integer',
            'custom_icon' => 'nullable|string',
        ];

        return $rules;
    }

}
