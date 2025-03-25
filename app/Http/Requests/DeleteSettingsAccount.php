<?php

namespace App\Http\Requests;

use App\Rules\GoodBye;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DeleteSettingsAccount extends FormRequest
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
        $user = Auth::user();
        $rules = [
            'goodbye' => ['string', new GoodBye],
        ];

        return $rules;
    }
}
