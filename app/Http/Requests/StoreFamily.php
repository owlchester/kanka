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

class StoreFamily extends FormRequest
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
            'sync_family_members' => 'nullable|boolean',
            'members' => 'nullable|array',
            'members.*' => ['nullable', 'regex:/^(m_)?[0-9]+$/'],
            'locations' => ['nullable', 'array', new EntityField(config('entities.ids.location'), Location::class)],
            'parent_id' => 'nullable|integer|exists:entities,id',
            'status_id' => ['nullable', 'exists:category_statuses,id'],
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

        return $this->entityRules($rules);
    }
}
