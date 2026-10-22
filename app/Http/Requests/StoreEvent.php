<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use App\Traits\EntityRequestRules;
use App\Traits\ResolvesNewForeignEntities;
use Illuminate\Foundation\Http\FormRequest;

class StoreEvent extends FormRequest
{
    use ApiRequest;
    use EntityRequestRules;
    use ResolvesNewForeignEntities;

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
            'date' => 'nullable|string|max:191',
        ];

        return $this->entityRules($rules);
    }
}
