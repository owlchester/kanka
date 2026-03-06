<?php

namespace App\Http\Requests;

use App\Facades\Limit;
use App\Rules\EntityLocations;
use App\Rules\UniqueAttributeNames;
use App\Traits\ApiRequest;
use App\Traits\ResolvesNewForeignEntities;
use Illuminate\Foundation\Http\FormRequest;

class StoreEvent extends FormRequest
{
    use ApiRequest;
    use ResolvesNewForeignEntities;

    protected array $foreignEntityFields = [];

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
     * Handle backwards compatibility for location_id -> locations
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('location_id') && ! $this->has('locations')) {
            $locationId = $this->input('location_id');
            $this->merge([
                'locations' => ! empty($locationId) ? [$locationId] : [],
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->clean([
            'name' => 'required|max:191',
            'entry' => 'nullable|string',
            'type' => 'nullable|string|max:191',
            'event_id' => 'nullable|integer|exists:events,id',
            'date' => 'nullable|max:191',
            'locations' => ['nullable', 'array', new EntityLocations],
            'image' => 'mimes:jpeg,png,jpg,gif,webp|max:' . Limit::upload(),
            'image_url' => 'nullable|url|active_url',
            'entity_image_uuid' => 'nullable|exists:images,id',
            'entity_header_uuid' => 'nullable|exists:images,id',
            'template_id' => 'nullable',
            'attribute' => ['array', new UniqueAttributeNames],
        ]);
    }
}
