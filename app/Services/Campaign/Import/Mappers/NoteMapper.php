<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Entity;
use App\Models\Note;

class NoteMapper extends MiscMapper
{
    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'note_id', 'created_at', 'updated_at'];

    protected string $className = Note::class;

    protected string $mappingName = 'notes';

    public function first(): void
    {
        $this
            ->prepareModel()
            ->trackMappings('note_id');
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $entityIds) {
            if (! isset($this->mapping[$parent])) {
                continue;
            }
            $parentEntity = Entity::where('entity_id', $this->mapping[$parent])
                ->where('type_id', config('entities.ids.note'))
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
