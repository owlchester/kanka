<?php

namespace App\Http\Requests;

use App\Models\Map;
use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMapSettings extends FormRequest
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
            'grid' => 'nullable|integer|min:1',
            'min_zoom' => 'nullable|numeric|min:' . Map::MIN_ZOOM . '|max:' . Map::MAX_ZOOM_REAL,
            'max_zoom' => 'nullable|numeric|min:1|max:' . Map::MAX_ZOOM,
            'initial_zoom' => 'nullable|numeric|min:' . Map::MIN_ZOOM . '|max:' . Map::MAX_ZOOM_REAL,
            'distance_measure' => 'nullable|numeric|min:0.001|max:100.99',
            'distance_name' => 'nullable|string|max:20',
            'center_x' => 'nullable|numeric',
            'center_y' => 'nullable|numeric',
            'center_marker_id' => [
                'nullable',
                'integer',
                Rule::exists('map_markers', 'id')->where(function ($query) {
                    $entity = $this->route('entity');
                    $query->where('map_id', $entity?->child?->id);
                }),
            ],
            'legacy_pins' => 'sometimes|boolean',
        ];

        return $this->clean($rules);
    }
}
