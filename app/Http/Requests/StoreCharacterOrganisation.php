<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreCharacterOrganisation extends FormRequest
{
    use ApiRequest;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->clean([
            'organisation_id' => 'required|exists:organisations,id',
            'role' => 'nullable|string|max:191',
            'is_private' => 'nullable|boolean',
            'parent_id' => 'nullable|exists:organisation_member,id',
        ]);
    }
}
