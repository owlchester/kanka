<?php

namespace App\Http\Requests;

use App\Facades\Limit;
use App\Models\Calendar;
use App\Rules\CalendarMoonOffset;
use App\Rules\CalendarFormat;
use App\Rules\Nested;
use App\Rules\UniqueAttributeNames;
use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreCalendar extends FormRequest
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
            'type' => 'nullable|max:191',
            'calendar_id' => 'nullable|integer|exists:calendars,id',
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
            'show_birthdays' => 'boolean',
            'template_id' => 'nullable',
            'attribute' => ['array', new UniqueAttributeNames()],
            'format'      => ['nullable', new CalendarFormat(), 'string', 'max:20'],
            //            'moon_offset' => [
            //                '*' => new CalendarMoonOffset()
            //            ],
        ];

        if (request()->has('quick-creator')) {
            $rules = [
                'name' => 'required|max:191',
                'type' => 'nullable|max:191',
                'calendar_id' => 'nullable|integer|exists:calendars,id'
            ];
        }

        $leapYear = request()->post('has_leap_year');
        if (request()->post('has_leap_year') == true) {
            $rules['leap_year_amount'] = 'required|numeric|min:-128|max:128';
            $rules['leap_year_offset'] = 'required|numeric|min:1|max:255';
            $rules['leap_year_start'] = 'required|numeric|min:1|max:255';
        }

        /** @var Calendar $self */
        $self = request()->route('calendar');
        if (!empty($self)) {
            $rules['calendar_id'] = [
                'nullable',
                'integer',
                'exists:calendars,id',
                new Nested(Calendar::class, $self)
            ];
        }

        return $this->clean($rules);
    }
}
