<?php

namespace App\Http\Requests;

use App\Models\Family;
use App\Models\Location;
use App\Models\Race;
use App\Rules\EntityField;
use App\Traits\ApiRequest;
use App\Traits\EntityRequestRules;
use Illuminate\Foundation\Http\FormRequest;

class StoreCharacter extends FormRequest
{
    use ApiRequest;
    use EntityRequestRules;

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
            'locations' => [
                'nullable',
                'array',
                new EntityField(
                    config('entities.ids.location'),
                    Location::class,
                ),
            ],
            'age' => 'nullable|string|max:25',
            'sex' => 'nullable|string|max:45',
            'pronouns' => 'nullable|string|max:45',
            'title' => 'nullable|string|max:191',
            'families' => [
                'nullable',
                'array',
                new EntityField(config('entities.ids.family'), Family::class),
            ],
            'races' => [
                'nullable',
                'array',
                new EntityField(config('entities.ids.race'), Race::class),
            ],
            'personality_name' => 'nullable|array',
            'personality_entry' => 'nullable|array',
            'appearance_name' => 'nullable|array',
            'appearance_entry' => 'nullable|array',
            'is_personality_visible' => 'nullable|boolean',
            'is_appearance_pinned' => 'nullable|boolean',
            'is_personality_pinned' => 'nullable|boolean',
            'save_races' => 'nullable|boolean',
            'save_families' => 'nullable|boolean',
            'character_save_organisations' => 'nullable|boolean',
            'organisations' => 'nullable|array',
            'organisations.*' => 'nullable|integer|exists:organisations,id',
            'organisation_roles' => 'nullable|array',
            'organisation_roles.*' => 'nullable|string',
            'organisation_statuses' => 'nullable|array',
            'organisation_statuses.*' => 'nullable|integer',
            'organisation_pins' => 'nullable|array',
            'organisation_pins.*' => 'nullable|integer',
            'organisation_privates' => 'nullable|array',
            'organisation_privates.*' => 'nullable|boolean',
            'status_id' => ['nullable', 'exists:category_statuses,id'],
        ];

        return $this->entityRules($rules);
    }
}
