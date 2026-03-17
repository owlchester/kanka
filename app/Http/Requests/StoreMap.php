<?php

namespace App\Http\Requests;

use App\Facades\Limit;
use App\Models\Entity;
use App\Models\Map;
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
            'max_zoom' => 'nullable|numeric|min:1|max:' . Map::MAX_ZOOM,
            'min_zoom' => 'nullable|numeric|min:' . Map::MIN_ZOOM . '|max:' . Map::MAX_ZOOM_REAL,
            'initial_zoom' => 'nullable|numeric|min:' . Map::MIN_ZOOM . '|max:' . Map::MAX_ZOOM_REAL,
            'attribute' => ['array', new UniqueAttributeNames],
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

        return $this->clean($rules);
    }
}
