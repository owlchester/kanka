<?php

namespace App\Http\Requests;

use App\Facades\Limit;
use App\Models\Entity;
use App\Models\Map;
use App\Models\Tag;
use App\Rules\EntityField;
use App\Rules\Nested;
use App\Rules\UniqueAttributeNames;
use App\Traits\ApiRequest;
use App\Traits\ResolvesNewForeignEntities;
use Illuminate\Foundation\Http\FormRequest;

class StoreMap extends FormRequest
{
    use ApiRequest;
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
            'name' => 'required|max:191',
            'entry' => 'nullable|string',
            'type' => 'nullable|string|max:191',
            'parent_id' => 'nullable|integer|exists:entities,id',
            'location_id' => 'nullable|integer|exists:locations,id',
            'image' => 'mimes:jpeg,png,jpg,gif,webp,svg|max:' . Limit::map()->upload(),
            'image_url' => 'nullable|url|active_url',
            'entity_image_uuid' => 'nullable|exists:images,id',
            'entity_header_uuid' => 'nullable|exists:images,id',
            'template_id' => 'nullable',
            'center_x' => 'nullable|numeric',
            'center_y' => 'nullable|numeric',
            'max_zoom' => 'nullable|numeric|min:1|max:' . $zoomLimits['max'],
            'min_zoom' => 'nullable|numeric|min:' . $zoomLimits['min'] . '|max:' . $zoomLimits['max'],
            'initial_zoom' => 'nullable|numeric|min:' . $zoomLimits['min'] . '|max:' . $zoomLimits['max'],
            'attribute' => ['array', new UniqueAttributeNames],
            'is_private' => 'nullable|boolean',
            'is_real' => 'nullable|boolean',
        ];

        /** @var Entity $self */
        $self = request()->route('entity');
        if (! empty($self)) {
            $rules['parent_id'] = [
                'nullable',
                'integer',
                'exists:entities,id',
                new Nested($self),
            ];
        }

        $rules['tags'] = [
            'nullable',
            'array',
            new EntityField(config('entities.ids.tag'), Tag::class),
        ];

        return $this->clean($rules);
    }

    /**
     * Resolve the zoom limits for a new map or an existing map update.
     *
     * @return array{min: int, max: int}
     */
    protected function zoomLimits(): array
    {
        if ($this->has('is_real')) {
            $isReal = $this->boolean('is_real');
        } else {
            $map = $this->route('map');
            if (! $map instanceof Map) {
                $entity = $this->route('entity');
                $map = $entity instanceof Entity ? $entity->child : null;
            }

            $isReal = $map instanceof Map && $map->isReal();
        }

        return config('limits.maps.zoom.' . ($isReal ? 'real' : 'default'));
    }
}
