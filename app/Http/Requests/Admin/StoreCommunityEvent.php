<?php


namespace App\Http\Requests\Admin;


use Illuminate\Foundation\Http\FormRequest;

class StoreCommunityEvent extends FormRequest
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
        return [
            'name' => 'required|max:191',
            'entry' => 'required',
            'excerpt' => 'nullable|string',
            'start_at' => 'required',
            'end_at' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:10000',
        ];
    }
}
