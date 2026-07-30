<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreExploreMapGroup extends FormRequest
{
    use ApiRequest;

    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:191',
            'colour' => 'nullable|string|max:7',
            'parent_id' => 'nullable|integer|exists:map_groups,id',
            'visibility_id' => 'required|integer|exists:visibilities,id',
            'is_shown' => 'boolean',
            'after_id' => 'nullable|integer|exists:map_groups,id',
        ];

        return $this->clean($rules);
    }
}
