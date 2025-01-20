<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UniqueAttributeNames;

class StoreCustomEntity extends FormRequest
{
    use ApiRequest;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */public function rules()
    {
        $rules = [
            'name' => 'required|max:191',
            'entry' => 'nullable|string',
            'type' => 'nullable|string|max:191',
            'image_uuid' => 'nullable|integer|exists:images,id',
            'attribute' => ['array', new UniqueAttributeNames()],
        ];

        return $this->clean($rules);
    }
}
