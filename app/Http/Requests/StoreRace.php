<?php

namespace App\Http\Requests;

use App\Facades\Limit;
use App\Models\Race;
use App\Rules\Nested;
use App\Rules\UniqueAttributeNames;
use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreRace extends FormRequest
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
            'race_id' => 'nullable|integer|exists:races,id',
            'image' => 'mimes:jpeg,png,jpg,gif,webp|max:' . Limit::upload(),
            'image_url' => 'nullable|url|active_url',
            'entity_image_uuid' => 'nullable|exists:images,id',
            'entity_header_uuid' => 'nullable|exists:images,id',
            'template_id' => 'nullable',
            'locations' => 'array',
            'locations.*' => 'distinct|exists:locations,id',
            'attribute' => ['array', new UniqueAttributeNames()],
        ];

        /** @var Race $self */
        $self = request()->route('race');
        if (!empty($self)) {
            $rules['race_id'] = [
                'nullable',
                'integer',
                'exists:races,id',
                new Nested(Race::class, $self)
            ];
        }

        return $this->clean($rules);
    }
}
