<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCalendarEra extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:191',
            'description' => 'nullable|string',
            'colour' => 'nullable|string|max:12',
            'visibility_id' => 'nullable|integer|exists:visibilities,id',
            'start_day' => 'nullable|integer|min:1',
            'start_month' => 'nullable|integer|min:1|required_with:start_day',
            'start_year' => 'required|integer',
            'end_day' => 'nullable|integer|min:1',
            'end_month' => 'nullable|integer|min:1|required_with:end_day',
            'end_year' => 'nullable|integer',
            'show_era_dates' => 'nullable|boolean',
        ];
    }
}
