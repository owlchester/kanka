<?php

namespace App\Http\Requests;

use App\Models\Entity;
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
        $zoomLimits = $this->zoomLimits();
        $rules = [
            'grid' => 'nullable|integer|min:1',
            'min_zoom' => 'nullable|numeric|min:' . $zoomLimits['min'] . '|max:' . $zoomLimits['max'],
            'max_zoom' => 'nullable|numeric|min:1|max:' . $zoomLimits['max'],
            'initial_zoom' => 'nullable|numeric|min:' . $zoomLimits['min'] . '|max:' . $zoomLimits['max'],
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

    /**
     * @return array{min: int, max: int}
     */
    protected function zoomLimits(): array
    {
        $entity = $this->route('entity');
        $map = $entity instanceof Entity ? $entity->child : null;
        $isReal = $map instanceof Map && $map->isReal();

        return config('limits.maps.zoom.' . ($isReal ? 'real' : 'default'));
    }
}
