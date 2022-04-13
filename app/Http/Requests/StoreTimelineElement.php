<?php


namespace App\Http\Requests;


use App\Rules\FontAwesomeIcon;
use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreTimelineElement extends FormRequest
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
            'entity_id' => 'required_without:name|exists:entities,id',
            'name' => 'nullable|string|max:191|required_without:entity_id',
            'era_id' => 'required|exists:timeline_eras,id',
            'entry' => 'nullable|string',
            'position' => 'nullable|integer',
            'colour' => 'nullable|string|max:12',
            'date' => 'nullable|string|max:45',
            'visibility' => 'string',
            'icon' => ['nullable', 'string'/*, new FontAwesomeIcon*/],
        ];

        return $this->clean($rules);
    }

}
