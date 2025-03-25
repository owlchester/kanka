<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreEntityLink extends FormRequest
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
            'name' => 'required|string|max:45',
            'url' => 'required|string|url',
            'icon' => 'nullable|string|max:45',
            'position' => 'nullable|integer',
            'visibility_id' => 'nullable|integer|exists:visibilities,id',
        ]);
    }
}
