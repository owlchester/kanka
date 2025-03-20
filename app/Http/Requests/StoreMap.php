<?php

namespace App\Http\Requests;

use App\Facades\Limit;
use App\Models\Map;
use App\Rules\Nested;
use App\Rules\UniqueAttributeNames;
use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreMap extends FormRequest
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
            'name' => 'required|max:191',
            'entry' => 'nullable|string',
            'type' => 'nullable|string|max:191',
            'map_id' => 'nullable|integer|exists:maps,id',
            'location_id' => 'nullable|integer|exists:locations,id',
            'image' => 'mimes:jpeg,png,jpg,gif,webp,svg|max:' . Limit::map()->upload(),
            'image_url' => 'nullable|url|active_url',
            'template_id' => 'nullable',
            'center_x' => 'nullable|numeric',
            'center_y' => 'nullable|numeric',
            'max_zoom' => 'nullable|numeric|min:1|max:' . Map::MAX_ZOOM,
            'min_zoom' => 'nullable|numeric|min:' . Map::MIN_ZOOM . '|max:' . Map::MAX_ZOOM_REAL,
            'initial_zoom' => 'nullable|numeric|min:' . Map::MIN_ZOOM . '|max:' . Map::MAX_ZOOM_REAL,
            'attribute' => ['array', new UniqueAttributeNames],
        ];

        /** @var Map $self */
        $self = request()->route('map');
        if (! empty($self)) {
            $rules['map_id'] = [
                'nullable',
                'integer',
                'exists:maps,id',
                new Nested(Map::class, $self),
            ];
        }

        return $this->clean($rules);
    }
}
