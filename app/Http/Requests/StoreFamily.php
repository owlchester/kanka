<?php

namespace App\Http\Requests;

use App\Facades\Limit;
use App\Models\Family;
use App\Rules\Nested;
use App\Rules\UniqueAttributeNames;
use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreFamily extends FormRequest
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
            'location_id' => 'nullable|integer|exists:locations,id',
            'family_id' => 'nullable|exists:families,id',
            'image' => 'mimes:jpeg,png,jpg,gif,webp|max:' . Limit::upload(),
            'image_url' => 'nullable|url|active_url',
            'template_id' => 'nullable',
            'attribute' => ['array', new UniqueAttributeNames()],
        ];

        /** @var Family $self */
        $self = request()->route('family');
        if (!empty($self)) {
            $rules['family_id'] = [
                'nullable',
                'integer',
                'exists:families,id',
                new Nested(Family::class, $self)
            ];
        }

        return $this->clean($rules);
    }
}
