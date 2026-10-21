<?php

namespace App\Http\Requests;

use App\Models\Entity;
use App\Rules\CalendarFormat;
use App\Rules\CalendarMoonOffset;
use App\Rules\Nested;
use App\Traits\ApiRequest;
use App\Traits\EntityRequestRules;
use App\Traits\ResolvesNewForeignEntities;
use Illuminate\Foundation\Http\FormRequest;

class StoreCalendar extends FormRequest
{
    use ApiRequest;
    use EntityRequestRules;
    use ResolvesNewForeignEntities;

    protected array $foreignEntityFields = [];

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
            'parent_id' => 'nullable|integer|exists:entities,id',
            'month_name' => 'required|array|min:1',
            'month_length' => 'required|array|min:1',
            'weekday' => 'required|array|min:2',
            'start_offset' => 'nullable|integer|min:0|max:99',
            'year_name' => 'nullable|array',
            'moon_name' => 'nullable|array',
            'moon_fullmoon' => 'nullable|array',
            'moon_offset' => 'required_with:moon_name|array',
            'moon_colour' => 'required_with:moon_name|array',
            'moon_id' => 'required_with:moon_name|nullable|array',
            'epoch_name' => 'nullable|array',
            'season_name' => 'nullable|array',
            'season_month' => 'nullable|array',
            'season_day' => 'nullable|array',
            'month_alias' => 'nullable|array',
            'month_type' => 'nullable|array',
            'year_number' => 'nullable|array',
            'week_number' => 'nullable|array',
            'week_name' => 'nullable|array',
            'current_year' => 'nullable|integer',
            'current_month' => 'nullable|integer|min:1',
            'current_day' => 'nullable|integer|min:1',
            'suffix' => 'nullable|string|max:45',
            'skip_year_zero' => 'nullable|boolean',
            'reset' => 'nullable|integer',
            'is_incrementing' => 'nullable|boolean',
            'leap_year_month' => 'nullable|integer|min:1',
            'show_birthdays' => 'boolean',
            'format' => ['nullable', 'bail', 'string', 'max:20', new CalendarFormat],
            //            'moon_offset' => [
            //                '*' => new CalendarMoonOffset()
            //            ],
        ];

        if (request()->has('quick-creator')) {
            $rules = [
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

        return $this->entityRules($rules);
    }
}
