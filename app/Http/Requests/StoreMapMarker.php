<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreMapMarker extends FormRequest
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
            'name' => 'nullable|string|required_without:entity_id',
            'entry' => 'nullable|string',
            'visibility_id' => 'nullable|integer|exists:visibilities,id',
            'entity_id' => 'nullable|integer|exists:entities,id|required_without:name',
            'group_id' => 'nullable|integer|exists:map_groups,id',

            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'colour' => 'max:7',
            'size_id' => 'nullable|integer',

            'shape_id' => 'required|integer',
            'custom_shape' => 'nullable|string',
            'polygon_style' => 'nullable|array',
            'polygon_style.stroke' => 'nullable|string|max:7',
            'polygon_style.stroke-width' => 'nullable|integer|min:1|max:20',
            'is_draggable' => 'boolean',
            'is_popupless' => 'boolean',
            'css' => 'nullable|string|max:45',

            'icon' => 'required|integer',
            'custom_icon' => 'nullable|string',
            'circle_radius' => 'nullable|integer|min:1',
            'opacity' => 'nullable|min:0|max:100|integer',

            'marker_size' => 'nullable|integer|min:10',
        ];

        return $this->clean($rules);
    }
}
