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
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:' . auth()->user()->maxUploadSize(),
            'image_url' => 'nullable|url|active_url',
            'month_name' => 'required|array|min:2',
            'weekday' => 'required|array|min:2',
            'year_name' => 'required|array',
            'moons' => 'nullable|array',
            'epochs' => 'nullable|array',
            'seasons' => 'nullable|array',
            'template_id' => 'nullable|exists:attribute_templates,id',
        ];

        $leapYear = request()->post('has_leap_year');
        if (request()->post('has_leap_year') == true) {
            $rules['leap_year_amount'] = 'required|numeric|min:-128|max:128';
            $rules['leap_year_offset'] = 'required|numeric|min:1|max:255';
            $rules['leap_year_start'] = 'required|numeric|min:1|max:255';
        }
        
        return $rules;
    }
}
