<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAttributes extends FormRequest
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
            'attribute' => 'array',
            'attribute.*.name' => 'required|distinct|max:191',

            //'attribute.*.name' => 'json',
            //'attribute.name' => 'distinct|required|string|max:191',

        ]);
    }

    protected function prepareForValidation()
    {
        $attributes = [];
        foreach ($this->attribute as $att) {
            $attributes[] = json_decode($att, true);
        }

        $this->merge([
            'attribute' => $attributes
        ]);
    }

}
