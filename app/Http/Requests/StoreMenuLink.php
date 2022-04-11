<?php

namespace App\Http\Requests;

use App\Rules\FontAwesomeIcon;
use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreMenuLink extends FormRequest
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
            'name' => 'required|max:191',
            'entity_id' => 'required_without_all:type,random_entity_type,dashboard_id|exists:entities,id',
            'type' => 'required_without_all:entity_id,random_entity_type,dashboard_id',
            'random_entity_type' => 'required_without_all:entity_id,type,dashboard_id',
            'dashboard_id' => 'required_without_all:entity_id,type,random_entity_type',
            'icon' => ['nullable', new FontAwesomeIcon],
            'tab' => 'nullable',
            'filters' => 'nullable|string|max:191',
            'menu' => 'nullable|string|max:45',
            'position' => 'nullable|integer|min:1|max:99',
        ]);
    }
}
