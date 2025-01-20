<?php

namespace App\Http\Requests;

use App\Facades\Limit;
use App\Rules\UniqueAttributeNames;
use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreDiceRoll extends FormRequest
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
            'parameters' => 'required|max:191',
            'character_id', 'integer|exists:character,id',
            'image' => 'mimes:jpeg,png,jpg,gif,webp|max:' . Limit::upload(),
            'attribute' => ['array', new UniqueAttributeNames()],
        ];

        if (request()->has('quick-creator')) {
            unset($rules['parameters']);
        }

        return $this->clean($rules);
    }
}
