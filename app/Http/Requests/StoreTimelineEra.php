<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreTimelineEra extends FormRequest
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
            'timeline_id' => 'prohibited',
            'name' => 'required|string|max:191',
            'entry' => 'nullable|string',
            'abbreviation' => 'nullable|string|max:191',
            'start_year' => 'nullable|integer',
            'end_year' => 'nullable|integer',
            'is_collapsed' => 'nullable|boolean',
        ];

        return $this->clean($rules);
    }
}
