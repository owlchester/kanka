<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConversationParticipant extends FormRequest
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
            'character_id' => 'integer|exists:characters,id|required_without_all:user_id',
            'user_id' => 'integer|exists:users,id|required_without_all:character_id',
        ];

        return $rules;
    }
}
