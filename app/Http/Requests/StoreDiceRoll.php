<?php

namespace App\Http\Requests;

use App\Facades\Limit;
use App\Traits\ApiRequest;
use App\Traits\EntityRequestRules;
use Illuminate\Foundation\Http\FormRequest;

class StoreDiceRoll extends FormRequest
{
    use ApiRequest;
    use EntityRequestRules;

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
            'parameters' => 'required|string|max:191',
            'character_id' => 'nullable|integer|exists:characters,id',
        ];

        if (request()->has('quick-creator')) {
            unset($rules['parameters']);
        }

        return $this->entityRules($rules);
    }
}
