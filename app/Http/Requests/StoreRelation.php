<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreRelation extends FormRequest
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
            'owner_id' => 'required|exists:entities,id',
            'targets' => 'required_without:target_id',
            'target.*' => 'exists:entities,id',
            'target_id' => 'required_without:targets|exists:entities,id|different:owner_id',
            'relation' => 'required|max:255',
            'visibility_id' => 'nullable|exists:visibilities,id',
            'attitude' => 'min:-100|max:100',
            'colour' => 'nullable|max:7',
            'is_pinned' => 'boolean',
        ]);
    }
}
