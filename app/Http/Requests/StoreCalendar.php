<?php

namespace App\Http\Requests;

use App\Rules\CalendarMoonOffset;
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
            'type' => 'nullable|max:191',
            'image' => 'mimes:jpeg,png,jpg,gif,webp|max:' . auth()->user()->maxUploadSize(),
            'image_url' => 'nullable|url|active_url',
            'month_name' => 'required|array|min:2',
            'month_length' => 'required|array|min:2',
            'weekday' => 'required|array|min:2',
            'start_offset' => 'nullable|integer|min:0|max:99',
            'year_name' => 'nullable|array',
            'moon_name' => 'nullable|array',
            'epoch_name' => 'nullable|array',
            'season_name' => 'nullable|array',
            'template_id' => 'nullable',
            'moon_offset' => [
                '*' => new CalendarMoonOffset
            ]
        ];

        $leapYear = request()->post('has_leap_year');
        if (request()->post('has_leap_year') == true) {
            $rules['leap_year_amount'] = 'required|numeric|min:-128|max:128';
            $rules['leap_year_offset'] = 'required|numeric|min:1|max:255';
            $rules['leap_year_start'] = 'required|numeric|min:1|max:255';
        }

        $self = request()->segment(5);
        if (!empty($self)) {
            $rules['calendar_id'] = 'integer|not_in:' . ((int) $self) . '|exists:calendars,id';
        }

        return $this->clean($rules);
    }
}
