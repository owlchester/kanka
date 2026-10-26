<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use App\Traits\EntityRequestRules;
use App\Traits\ResolvesNewForeignEntities;
use Illuminate\Foundation\Http\FormRequest;

class StoreItem extends FormRequest
{
    use ApiRequest;
    use EntityRequestRules;
    use ResolvesNewForeignEntities;

    protected array $foreignEntityFields = ['location_id'];

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
            'location_id' => 'nullable|integer|exists:locations,id',
            'creators' => 'nullable|array',
            'creators.*' => 'integer|exists:entities,id',
            'price' => 'nullable|string|max:191',
            'size' => 'nullable|string|max:191',
            'weight' => 'nullable|string|max:191',
        ];

        return $this->entityRules($rules);
    }
}
