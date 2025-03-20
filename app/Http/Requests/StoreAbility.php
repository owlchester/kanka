<?php

namespace App\Http\Requests;

use App\Facades\Limit;
use App\Models\Ability;
use App\Rules\Nested;
use App\Rules\UniqueAttributeNames;
use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreAbility extends FormRequest
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
            'name' => 'required|max:191',
            'entry' => 'nullable|string',
            'type' => 'nullable|string|max:191',
            'ability_id' => 'nullable|integer|exists:abilities,id',
            'charges' => 'nullable|max:120',
            'image' => 'mimes:jpeg,png,jpg,gif,webp|max:' . Limit::upload(),
            'image_url' => 'nullable|url|active_url',
            'template_id' => 'nullable',
            'attribute' => ['array', new UniqueAttributeNames],
        ];

        /** @var Ability $self */
        $self = request()->route('ability');
        if (! empty($self)) {
            $rules['ability_id'] = [
                'nullable',
                'integer',
                'exists:abilities,id',
                new Nested(Ability::class, $self),
            ];
        }

        return $this->clean($rules);
    }
}
