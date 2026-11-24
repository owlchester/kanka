<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreEventParticipant extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $campaign = $this->route('campaign');

        return [
            'entity_id' => ['required', 'integer', Rule::exists('entities', 'id')->where('campaign_id', $campaign->id)],
            'group_id' => ['nullable', 'integer', 'exists:event_groups,id'],
            'role' => ['nullable', 'string', 'max:191'],
        ];
    }

    public function after(): array
    {
        return [function (Validator $validator) {
            $event = $this->route('event');
            $entityId = $this->input('entity_id');
            if ($event && $entityId && $event->participants()->where('entity_id', $entityId)->exists()) {
                $validator->errors()->add('entity_id', __('events.participants.already_added'));
            }
        }];
    }
}
