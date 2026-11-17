<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Facades\ImportIdMapper;
use App\Models\Entity;
use App\Models\Event;

class EventMapper extends MiscMapper
{
    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'event_id', 'location_id', 'created_at', 'updated_at'];

    protected string $className = Event::class;

    protected string $mappingName = 'events';

    public function first(): void
    {
        $this
            ->prepareModel()
            ->trackMappings('event_id');
    }

    public function second(): void
    {
        $this->loadModel();
        $this->eventParticipants();
        $this
            ->entityLocations()
            ->saveModel()
            ->entitySecond();
    }

    private function eventParticipants(): void
    {
        $groups = [];
        // Ties in position are displayed newest-first, so import in reverse order.
        foreach (array_reverse((array) ($this->data['groups'] ?? [])) as $group) {
            if (! is_array($group) || ! isset($group['id'], $group['name'])) {
                continue;
            }
            $created = $this->model->groups()->create([
                'name' => $group['name'],
                'colour' => $group['colour'] ?? null,
                'position' => $group['position'] ?? 0,
            ]);
            $groups[(string) $group['id']] = $created->id;
        }

        foreach (array_reverse((array) ($this->data['participants'] ?? [])) as $participant) {
            if (! is_array($participant) || ! isset($participant['entity_id']) || ! ImportIdMapper::hasEntity($participant['entity_id'])) {
                continue;
            }
            $this->model->participants()->updateOrCreate([
                'entity_id' => ImportIdMapper::getEntity($participant['entity_id']),
            ], [
                'group_id' => $groups[$participant['group_id'] ?? ''] ?? null,
                'role' => $participant['role'] ?? null,
                'position' => $participant['position'] ?? 0,
            ]);
        }
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $entityIds) {
            if (! isset($this->mapping[$parent])) {
                continue;
            }
            $parentEntity = Entity::where('entity_id', $this->mapping[$parent])
                ->where('type_id', config('entities.ids.event'))
                ->first();
            if (! $parentEntity) {
                continue;
            }
            $entities = Entity::whereIn('id', $entityIds)->get();
            foreach ($entities as $entity) {
                $entity->parent_id = $parentEntity->id;
                $entity->saveQuietly();
            }
        }

        return $this;
    }
}
