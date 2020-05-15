<?php


namespace App\Http\Requests\Campaigns;


use Illuminate\Foundation\Http\FormRequest;

class DefaultImageStore extends FormRequest
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
            'entity_type' => 'required',
            'default_entity_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:' . auth()->user()->maxUploadSize(),
        ];
        return $rules;
    }
}
