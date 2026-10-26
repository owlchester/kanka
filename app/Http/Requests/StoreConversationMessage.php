<?php

namespace App\Http\Requests;

use App\Models\Conversation;
use Illuminate\Foundation\Http\FormRequest;

class StoreConversationMessage extends FormRequest
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
        $conversation = $this->route('conversation');
        $entityConversation = $conversation instanceof Conversation && $conversation->forEntities();
        $creating = $this->isMethod('POST');

        $entityRules = ['nullable', 'integer', 'exists:entities,id'];
        $userRules = ['nullable', 'integer', 'exists:users,id'];
        if ($creating && $entityConversation) {
            $entityRules[] = 'required';
            $userRules[] = 'prohibited';
        } elseif ($creating && $this->is('api/*')) {
            $entityRules[] = 'prohibited';
            $userRules[] = 'required';
        }

        $rules = [
            'message' => 'required|string',
            'entity_id' => $entityRules,
            'user_id' => $userRules,
        ];

        return $rules;
    }
}
