<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Facades\ImportIdMapper;
use App\Models\Entity;
use App\Models\Quest;
use App\Models\QuestElement;

class QuestMapper extends MiscMapper
{
    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'quest_id', 'created_at', 'updated_at', 'location_id', 'instigator_id'];

    protected string $className = Quest::class;

    protected string $mappingName = 'quests';

    public function first(): void
    {
        $this
            ->migrateOldStatus()
            ->prepareModel()
            ->trackMappings('quest_id');
    }

    /**
     * Backward compatibility: resolve old quest status fields to entities.status_id.
     * Old is_completed boolean or child status_id enum (0=not_started, 1=ongoing, 2=completed, 3=abandoned).
     */
    protected function migrateOldStatus(): self
    {
        if (array_key_exists('status_id', $this->data['entity'] ?? [])) {
            return $this;
        }

        $map = [0 => 'not_started', 1 => 'ongoing', 2 => 'completed', 3 => 'abandoned'];

        // Old is_completed boolean → enum value
        if (array_key_exists('is_completed', $this->data) && ! array_key_exists('status_id', $this->data)) {
            $this->data['status_id'] = $this->data['is_completed'] ? 2 : 0;
            unset($this->data['is_completed']);
        }

        // Child-level status_id enum → resolve to category_statuses
        if (array_key_exists('status_id', $this->data)) {
            $oldValue = (int) $this->data['status_id'];
            if (isset($map[$oldValue])) {
                $this->resolveOldStatusToEntity('quest', $map[$oldValue]);
            }
        }

        return $this;
    }

    public function second(): void
    {
        // @phpstan-ignore-next-line
        $this->loadModel()
            ->foreign('locations', 'location_id')
            ->foreign('entities', 'instigator_id')
            ->saveModel()
            ->elements()
            ->entitySecond();
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $entityIds) {
            if (! isset($this->mapping[$parent])) {
                continue;
            }
            $parentEntity = Entity::where('entity_id', $this->mapping[$parent])
                ->where('type_id', config('entities.ids.quest'))
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

    protected function elements(): self
    {
        $fields = [
            'role', 'entry', 'visibility_id', 'colour', 'name',
        ];
        foreach ($this->data['elements'] as $data) {
            $el = new QuestElement;
            $el->quest_id = $this->model->id;
            if (! empty($data['entity_id'])) {
                if (! ImportIdMapper::hasEntity($data['entity_id'])) {
                    continue;
                }
                $el->entity_id = ImportIdMapper::getEntity($data['entity_id']);
            }
            foreach ($fields as $field) {
                if (! array_key_exists($field, $data)) {
                    continue;
                }
                $el->$field = $data[$field];
            }
            $el->entry = $this->mentions($el->entry);
            $el->save();
            ImportIdMapper::putQuestElement($data['id'], $el->id);
        }

        return $this;
    }
}
