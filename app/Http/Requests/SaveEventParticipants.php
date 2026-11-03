<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveEventParticipants extends FormRequest
{
    public function authorize(): bool
    {
        $event = $this->route('event');

        return $event->campaign_id === $this->route('campaign')->id && $this->user()?->can('update', $event->entity) === true;
    }

    public function rules(): array
    {
        return self::payloadRules();
    }

    public static function payloadRules(): array
    {
        return [
            'revision' => ['required', 'string', 'size:64'],
            'groups' => ['present', 'array', 'max:100'],
            'groups.*.key' => ['required', 'string', 'max:80', 'distinct:strict'],
            'groups.*.name' => ['required', 'string', 'max:191'],
            'groups.*.colour' => ['present', 'nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'participants' => ['present', 'array', 'max:1000'],
            'participants.*.entity_id' => ['required', 'integer', 'distinct'],
            'participants.*.group' => ['present', 'nullable', 'string', 'max:80'],
            'participants.*.role' => ['present', 'nullable', 'string', 'max:191'],
        ];
    }
}
