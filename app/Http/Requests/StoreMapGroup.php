<?php

namespace App\Http\Requests;

use App\Models\MapGroup;
use App\Rules\Nested;
use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreMapGroup extends FormRequest
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
            'position' => 'nullable|string|max:3',
            'visibility_id' => 'nullable|integer|exists:visibilities,id',
            'parent_id' => 'nullable|integer|exists:map_groups,id',
        ];

        /** @var MapGroup $self */
        $self = request()->route('map_group');
        if (! empty($self)) {
            $rules['parent_id'] = [
                'nullable',
                'integer',
                'exists:map_groups,id',
                new Nested(MapGroup::class, $self),
            ];
        }

        return $this->clean($rules);
    }
}
