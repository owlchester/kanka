<?php

namespace App\Http\Requests\API;

use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreReminder extends FormRequest
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
        return $this->clean([
            'calendar_id' => 'required|integer|exists:calendars,id',
            'day' => 'required|integer|min:1',
            'month' => 'required|integer|min:1',
            'year' => 'required|integer',
            'length' => 'required|integer|min:1',
            'is_recurring' => 'nullable',
            'recurring_until' => 'nullable',
            'recurring_periodicity' => 'nullable|max:5',
            'colour' => 'nullable|string|max:7',
            'comment' => 'nullable|max:191',
            'type_id' => 'nullable|integer|exists:entity_event_types,id',
            'visibility_id' => 'nullable|integer|exists:visibilities,id',
        ]);
    }
}
