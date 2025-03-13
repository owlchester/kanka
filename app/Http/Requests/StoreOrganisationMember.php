<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrganisationMember extends FormRequest
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
            'organisation_id' => 'required|exists:organisations,id',
            'characters' => 'required_without:character_id|array|min:1',
            'characters.*' => 'distinct|required|distinct|exists:characters,id',
            'character_id' => 'required_without:characters|exists:characters,id',
            'role' => 'nullable',
            'is_private' => 'nullable',
            'parent_id' => 'nullable|exists:organisation_member,id',
        ]);
    }
}
