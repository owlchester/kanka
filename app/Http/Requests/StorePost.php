<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StorePost extends FormRequest
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
            'entity_id' => 'required|exists:entities,id',
            'name' => 'required|max:191',
            'visibility_id' => 'nullable|exists:visibilities,id',
            'is_pinned' => 'boolean',
            'position' => 'nullable|integer|min:-128|max:128',
            'entry' => 'nullable|string',
        ]);
    }
}
