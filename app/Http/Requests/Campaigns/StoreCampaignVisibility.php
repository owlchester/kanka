<?php


namespace App\Http\Requests\Campaigns;


use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignVisibility extends FormRequest
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
            'is_public' => 'required|boolean',
        ];
        return $rules;
    }
}
