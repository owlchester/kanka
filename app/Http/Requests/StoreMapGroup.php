<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class StoreMapGroup extends FormRequest
{
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
            'name' => 'required',
            'visibility' => 'string',
            'position' => 'nullable|string|max:3',
        ];

        return $rules;
    }

}
