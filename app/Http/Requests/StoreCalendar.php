<?php

namespace App\Http\Requests;

use App\Facades\Limit;
use App\Models\Entity;
use App\Rules\CalendarFormat;
use App\Rules\CalendarMoonOffset;
use App\Rules\Nested;
use App\Rules\UniqueAttributeNames;
use App\Traits\ApiRequest;
use App\Traits\ResolvesNewForeignEntities;
use Illuminate\Foundation\Http\FormRequest;

class StoreCalendar extends FormRequest
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
            'type' => 'nullable|max:191',
            'parent_id' => 'nullable|integer|exists:entities,id',
            'image' => 'mimes:jpeg,png,jpg,gif,webp|max:' . Limit::upload(),
            'image_url' => 'nullable|url|active_url',
            'entity_image_uuid' => 'nullable|exists:images,id',
            'month_name' => 'required|array|min:1',
            'month_length' => 'required|array|min:1',
            'weekday' => 'required|array|min:2',
            'start_offset' => 'nullable|integer|min:0|max:99',
            'year_name' => 'nullable|array',
            'moon_name' => 'nullable|array',
            'epoch_name' => 'nullable|array',
            'season_name' => 'nullable|array',
            'era_name' => 'nullable|array',
            'era_start_year' => 'nullable|array',
            'era_start_year.*' => 'nullable|integer',
            'era_end_year' => 'nullable|array',
            'era_end_year.*' => 'nullable|integer',
            'show_birthdays' => 'boolean',
            'template_id' => 'nullable',
            'attribute' => ['array', new UniqueAttributeNames],
            'is_private' => 'nullable|boolean',
            'format' => ['nullable', new CalendarFormat, 'string', 'max:20'],
            //            'moon_offset' => [
            //                '*' => new CalendarMoonOffset()
            //            ],
        ];

        if (request()->has('quick-creator')) {
            $rules = [
                'name' => 'required|max:191',
                'type' => 'nullable|max:191',
                'parent_id' => 'nullable|integer|exists:entities,id',
            ];
        }

        $rules['has_leap_year'] = 'boolean';
        $rules['leap_year_amount'] = 'exclude_if:has_leap_year,0|numeric|min:-128|max:128';
        $rules['leap_year_offset'] = 'exclude_if:has_leap_year,0|numeric|min:1|max:255';
        $rules['leap_year_start'] = 'exclude_if:has_leap_year,0|numeric|min:1|max:255';

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
