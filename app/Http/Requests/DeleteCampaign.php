<?php

namespace App\Http\Requests;

use App\Rules\CampaignDelete;
use Illuminate\Foundation\Http\FormRequest;

class DeleteCampaign extends FormRequest
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
            'delete' => ['required', 'string', new CampaignDelete],
        ];

        return $rules;
    }
}
