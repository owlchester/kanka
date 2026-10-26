<?php

namespace App\Http\Requests;

use App\Models\Entity;
use App\Models\Map;
use App\Traits\ApiRequest;
use App\Traits\EntityRequestRules;
use App\Traits\ResolvesNewForeignEntities;
use Illuminate\Foundation\Http\FormRequest;

class StoreMap extends FormRequest
{
    use ApiRequest;
    use EntityRequestRules;
    use ResolvesNewForeignEntities;

    protected array $foreignEntityFields = ['location_id'];

    protected bool $foreignEntityParent = true;

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
            'location_id' => 'nullable|integer|exists:locations,id',
            'center_x' => 'nullable|numeric',
            'center_y' => 'nullable|numeric',
            'max_zoom' => 'nullable|numeric|min:1|max:' . $zoomLimits['max'],
            'min_zoom' => 'nullable|numeric|min:' . $zoomLimits['min'] . '|max:' . $zoomLimits['max'],
            'initial_zoom' => 'nullable|numeric|min:' . $zoomLimits['min'] . '|max:' . $zoomLimits['max'],
            'is_real' => 'nullable|boolean',
        ];

        return $this->entityRules($rules);
    }

    /**
     * Resolve the zoom limits for a new map or an existing map update.
     *
     * @return array{min: int, max: int}
     */
    protected function zoomLimits(): array
    {
        $map = $this->route('map');
        if (! $map instanceof Map) {
            $entity = $this->route('entity');
            $map = $entity instanceof Entity ? $entity->child : null;
        }

        if ($this->has('is_real')) {
            $isReal = $this->boolean('is_real');
        } else {
            $isReal = $map instanceof Map && $map->isReal();
        }

        $limits = config('limits.maps.zoom.' . ($isReal ? 'real' : 'default'));
        if ($map instanceof Map && $map->isTiled()) {
            $limits['min'] = max(0, $limits['min']);
        }

        return $limits;
    }
}
