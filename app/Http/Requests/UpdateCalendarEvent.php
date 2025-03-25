<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCalendarEvent extends FormRequest
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
        return [
            'entity_id' => 'integer|exists:entities,id',
            'day' => 'required',
            'month' => 'required',
            'year' => 'required',
            'length' => 'required|integer|min:1',
            'is_recurring' => 'nullable',
            'recurring_until' => 'nullable',
            'recurring_periodicity' => 'nullable|max:5',
            'colour' => 'nullable|string|max:7',
            'comment' => 'nullable|max:191',
            'type_id' => 'nullable|integer|exists:entity_event_types,id',
            'visibility' => 'nullable|string|in:all,admin,self,members,admin-self',
        ];
    }
}
