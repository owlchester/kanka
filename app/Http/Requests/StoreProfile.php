<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProfile extends FormRequest
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
            'name' => 'required|min:4',
            'email' => 'required|unique:users,email,' . $user->id,
            'newsletter' => 'boolean',
        ];

        // Social media account, no password
        if (empty($user->provider)) {
            $rules['password'] = 'required|hash:' . $user->getAuthPassword();
            $rules['password_new'] = 'nullable|min:6|confirmed';
            $rules['password_new_confirmation'] = '';
        }

        return $rules;
    }
}
