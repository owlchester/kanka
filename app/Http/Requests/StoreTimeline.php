<?php

namespace App\Http\Requests;

use App\Facades\Limit;
use App\Models\Entity;
use App\Rules\Nested;
use App\Rules\UniqueAttributeNames;
use App\Traits\ApiRequest;
use App\Traits\ResolvesNewForeignEntities;
use Illuminate\Foundation\Http\FormRequest;

class StoreTimeline extends FormRequest
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
            'calendar_id' => 'nullable|integer|exists:calendars,id',
            'image' => 'mimes:jpeg,png,jpg,gif,webp,svg|max:' . Limit::upload(),
            'image_url' => 'nullable|url|active_url',
            'entity_image_uuid' => 'nullable|exists:images,id',
            'entity_header_uuid' => 'nullable|exists:images,id',
            'template_id' => 'nullable',
            'revert_order' => 'nullable',
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

        $rules['tags'] = 'nullable|array';
        $rules['tags.*'] = 'distinct|exists:tags,id';

        return $this->clean($rules);
    }
}
