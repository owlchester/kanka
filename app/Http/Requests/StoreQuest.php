<?php

namespace App\Http\Requests;

use App\Models\Entity;
use App\Models\Location;
use App\Rules\EntityField;
use App\Rules\Nested;
use App\Traits\ApiRequest;
use App\Traits\EntityRequestRules;
use App\Traits\ResolvesNewForeignEntities;
use Illuminate\Foundation\Http\FormRequest;

class StoreQuest extends FormRequest
{
    use ApiRequest;
    use EntityRequestRules;
    use ResolvesNewForeignEntities;

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
        $rules = [
            'status_id' => ['nullable', 'exists:category_statuses,id'],
            'parent_id' => 'nullable|integer|exists:entities,id',
            'character_id' => 'nullable|integer|exists:characters,id',
            'locations' => ['nullable', 'array', new EntityField(config('entities.ids.location'), Location::class)],
        ];

        // If the calendar is present and not null, but we aren't "skipping" it (editing but without permission)
        if (request()->has('calendar_id') && request()->post('calendar_id') !== null && ! request()->has('calendar_skip')) {
            $rules['calendar_day'] = 'required_with:calendar_id|min:1';
            $rules['calendar_year'] = 'required_with:calendar_id';

            if (request()->has('length')) {
                $rules['length'] = 'required_with:calendar_id|min:1';
            }
        }

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

        return $this->entityRules($rules);
    }
}
