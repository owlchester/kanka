<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use App\Traits\EntityRequestRules;
use Illuminate\Foundation\Http\FormRequest;

class StoreWhiteboard extends FormRequest
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
            'type' => 'nullable|string|max:45',
        ];

        return $this->entityRules($rules);
    }
}
