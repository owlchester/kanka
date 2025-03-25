<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRelation extends FormRequest
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
        return $this->clean([
            'target_id' => 'exists:entities,id',
            'relation' => 'max:255',
            'visibility_id' => 'exists:visibilities,id',
            'attitude' => 'min:-100|max:100',
            'colour' => 'max:7',
            'is_pinned' => 'boolean',
        ]);
    }
}
