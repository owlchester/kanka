<?php

namespace App\Services\Events;

use App\Enums\Permission;
use App\Facades\Avatar;
use App\Facades\EntityPermission;
use App\Http\Requests\SaveEventParticipants;
use App\Models\Entity;
use App\Models\Event;
use App\Models\EventParticipant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ParticipantService
{
    public function validate(array $data, int $campaignId, ?Event $event): array
    {
        $data = Validator::make($data, SaveEventParticipants::payloadRules())->validate();
        $existingKeys = $event?->groups()->pluck('id')->map(fn ($id) => (string) $id)->all() ?? [];
        $keys = array_column($data['groups'], 'key');
        foreach ($keys as $key) {
            if (! str_starts_with($key, 'new-') && ! in_array($key, $existingKeys, true)) {
                throw ValidationException::withMessages(['groups' => __('events.participants.invalid_group')]);
            }
        }
        $entities = Entity::where('campaign_id', $campaignId)->whereIn('id', array_column($data['participants'], 'entity_id'))->get()->keyBy('id');
        foreach ($data['participants'] as $participant) {
            $entity = $entities->get($participant['entity_id']);
            if (! $entity || Gate::denies('view', $entity)) {
                throw ValidationException::withMessages(['participants' => __('events.participants.invalid_entity')]);
            }
            if ($participant['group'] !== null && ! in_array($participant['group'], $keys, true)) {
                throw ValidationException::withMessages(['participants' => __('events.participants.invalid_group')]);
            }
        }
        if ($event && ! hash_equals($this->revision($event), $data['revision'])) {
            throw ValidationException::withMessages(['participants' => __('events.participants.conflict')]);
        }

        return $data;
    }

    public function state(Event $event): array
    {
        $participants = $event->participants()->with(['entity.image', 'entity.entityType'])->get();

        return [
            'revision' => $this->revision($event),
            'groups' => $event->groups()->get()->map(fn ($group) => [
                'key' => (string) $group->id,
                'name' => $group->name,
                'colour' => $group->colour,
            ])->values()->all(),
            'participants' => $participants->filter(fn ($participant) => $participant->entity?->campaign_id === $event->campaign_id && $this->visible($participant))->map(fn ($participant) => [
                'entity_id' => $participant->entity_id,
                'name' => $participant->entity->name,
                'url' => route('entities.show', [$event->campaign, $participant->entity]),
                'image' => Avatar::entity($participant->entity)->size(80)->fallback()->thumbnail(),
                'group' => $participant->group_id ? (string) $participant->group_id : null,
                'role' => $participant->role ?? '',
            ])->values()->all(),
        ];
    }

    public function save(Event $event, array $data): array
    {
        return DB::transaction(function () use ($event, $data) {
            Event::whereKey($event->id)->lockForUpdate()->firstOrFail();
            if (! hash_equals($this->revision($event), $data['revision'])) {
                abort(409, __('events.participants.conflict'));
            }
            $data = $this->validate($data, $event->campaign_id, $event);

            $existing = $event->participants()->with('entity')->get();
            $groups = $event->groups()->get()->keyBy('id');
            $mapped = [];
            foreach ($data['groups'] as $position => $values) {
                $group = $groups->get($values['key']);
                if (! $group && ! str_starts_with($values['key'], 'new-')) {
                    throw ValidationException::withMessages(['groups' => __('events.participants.invalid_group')]);
                }
                $attributes = ['name' => $values['name'], 'colour' => $values['colour'], 'position' => $position];
                if ($group) {
                    $group->update($attributes);
                } else {
                    $group = $event->groups()->create($attributes);
                }
                $mapped[$values['key']] = $group->id;
            }

            foreach ($data['participants'] as $position => $values) {
                $event->participants()->updateOrCreate(['entity_id' => $values['entity_id']], [
                    'group_id' => $values['group'] !== null ? $mapped[$values['group']] : null,
                    'role' => $values['role'],
                    'position' => $position,
                ]);
            }

            $retained = array_column($data['participants'], 'entity_id');
            foreach ($existing as $participant) {
                if ($this->visible($participant) && ! in_array($participant->entity_id, $retained)) {
                    $participant->delete();
                }
            }
            foreach ($groups as $group) {
                if (! in_array($group->id, $mapped)) {
                    $group->participants()->update(['group_id' => null]);
                    $group->delete();
                }
            }

            return $this->state($event);
        });
    }

    private function visible(EventParticipant $participant): bool
    {
        if (! $participant->entity) {
            return false;
        }

        return auth()->check()
            ? Gate::allows('view', $participant->entity)
            : (bool) EntityPermission::entity($participant->entity)->campaign($participant->entity->campaign)->can(Permission::View);
    }

    private function revision(Event $event): string
    {
        return hash('sha256', json_encode([
            $event->groups()->get()->toArray(),
            $event->participants()->get()->toArray(),
        ], JSON_THROW_ON_ERROR));
    }
}
