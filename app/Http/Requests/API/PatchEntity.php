<?php

namespace App\Http\Requests\API;

use App\Models\Entity;
use App\Rules\Nested;
use App\Traits\ApiRequest;
use App\Traits\EntityRequestRules;
use Illuminate\Foundation\Http\FormRequest;

class PatchEntity extends FormRequest
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

    /*
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'nullable|string|max:191',
            'tooltip' => 'nullable|string',
        ];

        // Editing an special entity type? Don't allow selecting oneself.
        /** @var Entity $self */
        $self = request()->route('entity');
        if (! empty($self)) {
            $rules['parent_id'] = [
                'nullable',
                'integer',
                'exists:entities,id',
                new Nested($self),
            ];
        }

        $rules['is_template'] = 'nullable|boolean';

        return $this->entityRules($rules);
    }
}
