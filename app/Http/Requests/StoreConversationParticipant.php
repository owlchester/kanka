<?php

namespace App\Http\Requests;

use App\Models\Conversation;
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
        $entityConversation = $this->route('conversation') instanceof Conversation
            && $this->route('conversation')->forEntities();

        $rules = [
            'entity_ids' => ['nullable', 'array', $entityConversation ? 'required' : 'prohibited'],
            'entity_ids.*' => ['integer', 'distinct', 'exists:entities,id'],
            'user_ids' => ['nullable', 'array', $entityConversation ? 'prohibited' : 'required'],
            'user_ids.*' => ['integer', 'distinct', 'exists:users,id'],
            'entity_id' => ['nullable', 'integer', 'exists:entities,id', $entityConversation ? 'required_without:entity_ids' : 'prohibited'],
            'user_id' => ['nullable', 'integer', 'exists:users,id', $entityConversation ? 'prohibited' : 'required_without:user_ids'],
        ];

        return $rules;
    }
}
