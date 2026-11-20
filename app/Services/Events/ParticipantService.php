<?php

namespace App\Services\Events;

use App\Enums\Permission;
use App\Http\Requests\SaveEventParticipants;
use App\Models\Entity;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Services\Images\Avatar;
use App\Services\Permissions\EntityPermission;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ParticipantService
{
    public function validate(array $data, int $campaignId, ?Event $event): array
    {
        return DB::transaction(function () use ($data, $campaignId, $event) {
            $groups = $event?->groups()->get();
            $participants = $event?->participants()->get();
            $data = $this->validateWithGroups($data, $campaignId, $groups);
            if ($event && ! hash_equals($this->revision($groups, $participants), $data['revision'])) {
                throw ValidationException::withMessages(['participants' => __('events.participants.conflict')]);
            }

            return $data;
        });
    }

    private function validateWithGroups(array $data, int $campaignId, ?Collection $groups): array
    {
        $data = Validator::make($data, SaveEventParticipants::payloadRules())->validate();
        $existingKeys = $groups?->pluck('id')->map(fn ($id) => (string) $id)->all() ?? [];
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

        return $data;
    }

    public function state(Event $event): array
    {
        return DB::transaction(function () use ($event) {
            $groups = $event->groups()->get();
            $participants = $event->participants()->with(['entity.image', 'entity.entityType'])->get();

            return $this->stateFromSnapshot($event, $groups, $participants);
        });
    }

    private function stateFromSnapshot(Event $event, Collection $groups, Collection $participants): array
    {
        return [
            'revision' => $this->revision($groups, $participants),
            'groups' => $groups->map(fn ($group) => [
                'key' => (string) $group->id,
                'name' => $group->name,
                'colour' => $group->colour,
            ])->values()->all(),
            'participants' => $participants->filter(fn ($participant) => $participant->entity?->campaign_id === $event->campaign_id && $this->visible($participant))->map(fn ($participant) => [
                'entity_id' => $participant->entity_id,
                'name' => $participant->entity->name,
                'url' => route('entities.show', [$event->campaign, $participant->entity]),
                'image' => Avatar::for($participant->entity)->size(80)->fallback()->thumbnail(),
                'group' => $participant->group_id ? (string) $participant->group_id : null,
                'role' => $participant->role ?? '',
            ])->values()->all(),
        ];
    }

    public function save(Event $event, array $data): array
    {
        return DB::transaction(function () use ($event, $data) {
            Event::whereKey($event->id)->lockForUpdate()->firstOrFail();
            $groups = $event->groups()->lockForUpdate()->get();
            $participants = $event->participants()->with('entity')->lockForUpdate()->get();
            if (! hash_equals($this->revision($groups, $participants), $data['revision'])) {
                abort(409, __('events.participants.conflict'));
            }
            $data = $this->validateWithGroups($data, $event->campaign_id, $groups);

            $existing = $participants->keyBy('entity_id');
            $groups = $groups->keyBy('id');
            $mapped = [];
            foreach ($data['groups'] as $position => $values) {
                $group = $groups->get($values['key']);
                if (! $group && ! str_starts_with($values['key'], 'new-')) {
                    throw ValidationException::withMessages(['groups' => __('events.participants.invalid_group')]);
                }
                $attributes = ['name' => $values['name'], 'colour' => $values['colour'], 'position' => $position];
                if ($group) {
                    $group->fill($attributes);
                    if ($group->isDirty()) {
                        $group->save();
                    }
                } else {
                    $group = $event->groups()->create($attributes);
                }
                $mapped[$values['key']] = $group->id;
            }

            foreach ($data['participants'] as $position => $values) {
                $attributes = [
                    'group_id' => $values['group'] !== null ? $mapped[$values['group']] : null,
                    'role' => $values['role'],
                    'position' => $position,
                ];
                $participant = $existing->get($values['entity_id']);
                if (! $participant) {
                    $event->participants()->create($attributes + ['entity_id' => $values['entity_id']]);
                } else {
                    $participant->fill($attributes);
                    if ($participant->isDirty()) {
                        $participant->save();
                    }
                }
            }

            $retained = array_fill_keys(array_column($data['participants'], 'entity_id'), true);
            foreach ($existing as $participant) {
                if (! isset($retained[$participant->entity_id]) && $this->visible($participant)) {
                    $participant->delete();
                }
            }
            foreach ($groups as $group) {
                if (! in_array($group->id, $mapped)) {
                    $group->participants()->update(['group_id' => null]);
                    $group->delete();
                }
            }

            $groups = $event->groups()->get();
            $participants = $event->participants()->with(['entity.image', 'entity.entityType'])->get();

            return $this->stateFromSnapshot($event, $groups, $participants);
        });
    }

    private function visible(EventParticipant $participant): bool
    {
        if (! $participant->entity) {
            return false;
        }

        return auth()->check()
            ? Gate::allows('view', $participant->entity)
            : app(EntityPermission::class)->canEntity($participant->entity, Permission::View, null, $participant->entity->campaign);
    }

    private function revision(Collection $groups, Collection $participants): string
    {
        return hash('sha256', json_encode([
            $groups->map(fn ($group) => $group->getAttributes())->all(),
            $participants->map(fn ($participant) => $participant->getAttributes())->all(),
        ], JSON_THROW_ON_ERROR));
    }
}
