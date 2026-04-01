<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Entity;
use App\Models\Journal;

class JournalMapper extends MiscMapper
{
    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'journal_id', 'location_id', 'author_id', 'created_at', 'updated_at'];

    protected string $className = Journal::class;

    protected string $mappingName = 'journals';

    public function first(): void
    {
        $this
            ->prepareModel()
            ->trackMappings('journal_id');
    }

    public function second(): void
    {
        $this
            ->loadModel()
            ->foreign('locations', 'location_id')
            ->foreign('entities', 'author_id')
            ->saveModel()
            ->entitySecond();
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $entityIds) {
            if (! isset($this->mapping[$parent])) {
                continue;
            }
            $parentEntity = Entity::where('entity_id', $this->mapping[$parent])
                ->where('type_id', config('entities.ids.journal'))
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
