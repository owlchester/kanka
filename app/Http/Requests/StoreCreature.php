<?php

namespace App\Http\Requests;

use App\Facades\Limit;
use App\Models\Creature;
use App\Models\Entity;
use App\Rules\EntityLocations;
use App\Rules\Nested;
use App\Rules\UniqueAttributeNames;
use App\Traits\ApiRequest;
use App\Traits\ResolvesNewForeignEntities;
use Illuminate\Foundation\Http\FormRequest;

class StoreCreature extends FormRequest
{
    use ApiRequest;
    use ResolvesNewForeignEntities;

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
            'creature_id' => 'nullable|integer|exists:creatures,id',
            'image' => 'mimes:jpeg,png,jpg,gif,webp|max:' . Limit::upload(),
            'image_url' => 'nullable|url|active_url',
            'entity_image_uuid' => 'nullable|exists:images,id',
            'entity_header_uuid' => 'nullable|exists:images,id',
            'template_id' => 'nullable',
            'locations' => ['nullable', 'array', new EntityLocations],
            'attribute' => ['array', new UniqueAttributeNames],
        ];

        /** @var Entity $self */
        $self = request()->route('entity');
        if (! empty($self) && $self->isCreature()) {
            $rules['creature_id'] = [
                'nullable',
                'integer',
                'exists:creatures,id',
                new Nested(Creature::class, $self->child),
            ];
        }

        return $this->clean($rules);
    }

    protected function newEntityFields(): array
    {
        return [
            'creature_id' => [Creature::class, config('entities.ids.creature')],
        ];
    }
}
