<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreEntityPermission extends FormRequest
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
        return [
            '*.campaign_role_id' => ['required_without:*.user_id', 'integer', 'exists:campaign_roles,id'],
            '*.user_id' => ['required_without:*.campaign_role_id', 'integer', 'exists:users,id'],
            '*.access' => ['required', 'boolean'],
            '*.action' => ['required', 'numeric'],
        ];
    }
}
