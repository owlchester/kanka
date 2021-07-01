<?php


namespace App\Http\Requests\Admin;


use Illuminate\Foundation\Http\FormRequest;

class StoreFaq extends FormRequest
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
            'faq_category_id' => 'required|integer|exists:faq_categories,id',
            'question' => 'required',
            'answer' => 'required',
            'order' => 'required|integer',
            'visible' => 'nullable',
            'locale' => 'required',
        ];
    }
}
