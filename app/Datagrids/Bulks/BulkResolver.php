<?php

namespace App\Datagrids\Bulks;

class BulkResolver
{
    private const array ENTITY_FIELDS = ['tags', 'private_choice', 'entity_image', 'entity_header'];

    public function for(string $type, bool $entityFallback = false): Bulk
    {
        return match ($type) {
            'entity', 'creature', 'family', 'race' => new EntityBulk,
            'ability', 'note', 'timeline' => $this->entity(['name', 'type', 'parent_id']),
            'attribute_template' => new Bulk(
                ['name', 'parent_id', 'entity_type_id', 'private_choice', 'enabled_choice', 'entity_image', 'entity_header'],
                booleans: ['is_enabled'],
            ),
            'bookmark' => new Bulk(['name', 'icon', 'private_choice', 'is_active']),
            'calendar' => new Bulk(['name', 'type', 'parent_id', 'tags', 'private_choice', 'format', 'entity_image', 'entity_header']),
            'character' => new Bulk(
                ['name', 'title', 'families', 'entity_locations', 'races', 'type', 'sex', 'status_id', 'age', 'organisations', ...self::ENTITY_FIELDS],
                foreignRelations: ['races', 'families', 'organisations'],
                maths: ['age'],
            ),
            'conversation' => $this->entity(['name']),
            'dice_roll' => $this->entity(['name', 'character_id']),
            'event' => $this->entity(['name', 'type', 'parent_id', 'entity_locations']),
            'item' => $this->entity(['name', 'type', 'price', 'size', 'weight', 'parent_id', 'locations', 'creators', 'status_id']),
            'journal' => $this->entity(['name', 'type', 'parent_id', 'author_id', 'date', 'locations']),
            'location' => $this->entity(['name', 'title', 'type', 'status_id', 'parent_id']),
            'map' => $this->entity(['name', 'type', 'parent_id', 'location_id']),
            'organisation' => $this->entity(['name', 'type', 'locations', 'status_id', 'parent_id']),
            'quest' => $this->entity(['name', 'type', 'parent_id', 'instigator_id', 'date', 'locations', 'status_id']),
            'relation' => new Bulk(
                ['owner_id', 'target_id', 'relation', 'attitude', 'colour_picker', 'pinned_choice', 'visibility_id', 'update_mirrored', 'unmirror'],
                booleans: ['colour', 'is_pinned'],
            ),
            'tag' => new Bulk(
                ['name', 'type', 'colour_picker', 'parent_id', 'private_choice', 'auto_applied_choice', 'hide_choice', 'tags', 'entity_image', 'entity_header'],
                booleans: ['colour', 'is_auto_applied', 'is_hidden'],
            ),
            default => $entityFallback ? new EntityBulk : new Bulk,
        };
    }

    private function entity(array $fields): Bulk
    {
        return new Bulk([...$fields, ...self::ENTITY_FIELDS]);
    }
}
