<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use App\Traits\EntityRequestRules;
use App\Traits\ResolvesNewForeignEntities;
use Illuminate\Foundation\Http\FormRequest;

class StoreTag extends FormRequest
{
    use ApiRequest;
    use EntityRequestRules;
    use ResolvesNewForeignEntities;

    protected array $foreignEntityFields = [];

    protected bool $foreignEntityParent = true;

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
            'icon' => ['nullable', 'string', 'max:100', 'regex:/^(fa-|ra )/'],
            'colour' => [
                'nullable',
                'string',
                'max:7',
            ],
            'is_auto_applied' => 'nullable|boolean',
            'is_hidden' => 'nullable|boolean',
        ];

        return $this->entityRules($rules);
    }
}
