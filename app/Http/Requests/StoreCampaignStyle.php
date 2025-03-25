<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignStyle extends FormRequest
{
    use ApiRequest;

    public const MAX = 60000;

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
            'name' => 'required|string|max:45',
            'content' => ['required', 'max:' . self::MAX],
            'is_enabled' => 'nullable',
        ]);
    }
}
