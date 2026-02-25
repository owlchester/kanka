<?php

namespace App\Http\Requests\Campaigns;

use Illuminate\Foundation\Http\FormRequest;

class StoreDefaults extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'entity_visibility' => 'boolean',
            'entity_personality_visibility' => 'boolean',
            'settings' => 'array',
            'settings.default_visibility' => 'nullable|string|in:admin,members,self,admin-self',
            'settings.private_mention_visibility' => 'boolean',
            'ui_settings' => 'array',
            'ui_settings.connections' => 'boolean',
            'ui_settings.connection_mode' => 'boolean',
            'ui_settings.descendants' => 'boolean',
        ];
    }
}
