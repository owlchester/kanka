<?php

namespace App\Http\Requests;

use App\Rules\ApiUniqueAttributeNames;
use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\AttributeType;

class SaveAttributesApi extends FormRequest
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
            'attribute' => ['array', new ApiUniqueAttributeNames],
            'attribute.*' => ['array'],
            'attribute.*.name' =>  ['nullable', 'string'],
            'attribute.*.id' => ['nullable', 'integer', 'exists:attributes,id'],
            'attribute.*.type_id' => [
                'required_without:attribute.*.id',
                new Enum(AttributeType::class),
            ],
        ]);
    }
}
