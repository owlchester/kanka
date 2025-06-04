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
            'name' => ['required', 'max:191', new \App\Rules\Lessless],
            'visibility_id' => 'nullable|exists:visibilities,id',
            'location_id' => 'nullable|exists:locations,id',
            'is_pinned' => 'boolean',
            'position' => 'nullable|integer|min:-128|max:128',
            'entry' => 'nullable|string',
            'layout_id' => 'nullable|integer|exists:post_layouts,id',
        ]);
    }
}
