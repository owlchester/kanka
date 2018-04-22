<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCalendar extends FormRequest
{
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
            'name' => 'required',
            'type' => 'max:191',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:8192',
            'image_url' => 'nullable|url|active_url',
            'month_name' => 'required|array|min:2',
            'weekday' => 'required|array|min:2',
            'year_name' => 'required|array',

        ];

        $leapYear = request()->post('has_leap_year');
        if (request()->post('has_leap_year') == true) {
            $rules['leap_year_amount'] = 'required|numeric|min:1';
            $rules['leap_year_offset'] = 'required|numeric|min:1';
            $rules['leap_year_start'] = 'required|numeric|min:1';
        }
        
        return $rules;
    }
}
