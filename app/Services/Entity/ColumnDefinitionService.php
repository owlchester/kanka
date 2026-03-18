<?php

namespace App\Services\Entity;

use App\Enums\CharacterStatus;
use App\Enums\QuestStatus;
use App\Models\Campaign;
use App\Models\EntityType;
use Illuminate\Support\Str;

class ColumnDefinitionService
{
    public function columns(EntityType $entityType, Campaign $campaign): array
    {
        $method = Str::camel($entityType->code);
        if (method_exists($this, $method)) {
            return $this->filterByModules(
                $this->{$method}(),
                $campaign
            );
        }

        return $this->filterByModules(
            $this->defaultColumns(),
            $campaign
        );
    }

    /**
     * @return string[] Sort keys for all sortable columns
     */
    public function sortableFields(EntityType $entityType, Campaign $campaign): array
    {
        $columns = $this->columns($entityType, $campaign);

        return array_values(array_filter(array_map(
            fn (array $col) => $col['sortable'] ? ($col['sortKey'] ?? $col['key']) : null,
            $columns
        )));
    }

    public function defaultVisibleColumns(EntityType $entityType, Campaign $campaign): array
    {
        $columns = $this->columns($entityType, $campaign);

        return array_values(array_map(
            fn (array $col) => $col['key'],
            array_filter($columns, fn (array $col) => ! ($col['adminOnly'] ?? false))
        ));
    }

    public function relationMap(EntityType $entityType, Campaign $campaign): array
    {
        $map = ['entityType', 'image', 'tags', 'parent'];

        $typeRelations = $this->typeRelations();

        foreach ($this->columns($entityType, $campaign) as $col) {
            if (isset($typeRelations[$col['key']])) {
                $map = array_merge($map, $typeRelations[$col['key']]);
            }
        }

        return array_unique($map);
    }

    /**
     * @return string[] Child model relation names that need withCount (e.g. ['members', 'elements'])
     */
    public function childCountRelations(EntityType $entityType, Campaign $campaign): array
    {
        $countColumns = [
            'members_count' => 'members',
            'elements_count' => 'elements',
            'eras_count' => 'eras',
            'entities_count' => 'entities',
        ];

        $needed = [];
        foreach ($this->columns($entityType, $campaign) as $col) {
            if (isset($countColumns[$col['key']])) {
                $needed[] = $countColumns[$col['key']];
            }
        }

        return $needed;
    }

    /**
     * @return string[] Entity relation names that need withCount (e.g. ['attributes'])
     */
    public function entityCountRelations(EntityType $entityType, Campaign $campaign): array
    {
        $countColumns = [
            'attributes_count' => 'attributes',
        ];

        $needed = [];
        foreach ($this->columns($entityType, $campaign) as $col) {
            if (isset($countColumns[$col['key']])) {
                $needed[] = $countColumns[$col['key']];
            }
        }

        return $needed;
    }

    protected function typeRelations(): array
    {
        return [
            'families' => ['character.characterFamilies.family.entity'],
            'races' => ['character.characterRaces.race.entity'],
            'locations' => ['locations.entity'],
            'location' => ['location.entity'],
            'calendar_date' => ['calendarDate.calendar.entity'],
            'author' => ['journal.author'],
            'organisation' => ['organisation.entity'],
            'character' => ['character.entity'],
            'instigator' => ['quest.instigator'],
            'creators' => ['item.itemCreators.creator'],
            'entity_type_name' => ['attributeTemplate.entityType'],
        ];
    }

    protected function filterByModules(array $columns, Campaign $campaign): array
    {
        return array_values(array_filter($columns, function (array $col) use ($campaign) {
            if (! empty($col['moduleGate'])) {
                return $campaign->enabled($col['moduleGate']);
            }

            return true;
        }));
    }

    // --- Entity type column definitions ---

    protected function defaultColumns(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => true],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function character(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'title', 'type' => 'text', 'label' => __('characters.fields.title'), 'sortable' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'status', 'type' => 'icon', 'label' => __('characters.fields.status'), 'sortable' => true, 'sortKey' => 'status_id', 'icons' => [
                CharacterStatus::dead->value => ['icon' => 'fa-regular fa-skull', 'tooltip' => __('characters.hints.is_dead')],
                CharacterStatus::missing->value => ['icon' => 'fa-regular fa-question', 'tooltip' => __('characters.hints.is_missing')],
            ]],
            ['key' => 'families', 'type' => 'entities', 'label' => __('entities.families'), 'sortable' => false, 'moduleGate' => 'families'],
            ['key' => 'locations', 'type' => 'entities', 'label' => __('entities.locations'), 'sortable' => false, 'moduleGate' => 'locations'],
            ['key' => 'races', 'type' => 'entities', 'label' => __('entities.races'), 'sortable' => false, 'moduleGate' => 'races'],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => true],
            ['key' => 'sex', 'type' => 'text', 'label' => __('characters.fields.sex'), 'sortable' => true],
            ['key' => 'pronouns', 'type' => 'text', 'label' => __('characters.fields.pronouns'), 'sortable' => true],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function location(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'title', 'type' => 'text', 'label' => __('locations.fields.title'), 'sortable' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'is_destroyed', 'type' => 'icon', 'label' => __('locations.fields.is_destroyed'), 'sortable' => true, 'icon' => 'fa-regular fa-building-circle-xmark', 'tooltip' => __('locations.fields.is_destroyed')],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => true],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function organisation(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'locations', 'type' => 'entities', 'label' => __('entities.locations'), 'sortable' => false, 'moduleGate' => 'locations'],
            ['key' => 'members_count', 'type' => 'count', 'label' => __('organisations.fields.members'), 'sortable' => false, 'moduleGate' => 'characters'],
            ['key' => 'is_defunct', 'type' => 'icon', 'label' => __('organisations.fields.is_defunct'), 'sortable' => true, 'icon' => 'fa-regular fa-skull', 'tooltip' => __('organisations.fields.is_defunct')],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => true],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function family(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'location', 'type' => 'entity', 'label' => __('entities.location'), 'sortable' => true, 'sortKey' => 'location.name', 'moduleGate' => 'locations'],
            ['key' => 'members_count', 'type' => 'count', 'label' => __('organisations.fields.members'), 'sortable' => false],
            ['key' => 'is_extinct', 'type' => 'icon', 'label' => __('creatures.fields.is_extinct'), 'sortable' => true, 'icon' => 'fa-regular fa-skull', 'tooltip' => __('creatures.fields.is_extinct')],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => true],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function journal(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'date', 'type' => 'text', 'label' => __('journals.fields.date'), 'sortable' => true],
            ['key' => 'calendar_date', 'type' => 'calendar_date', 'label' => __('crud.fields.calendar_date'), 'sortable' => true],
            ['key' => 'author', 'type' => 'entity', 'label' => __('journals.fields.author'), 'sortable' => true, 'sortKey' => 'author.name'],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => true],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function quest(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'status', 'type' => 'icon', 'label' => __('characters.fields.status'), 'sortable' => true, 'sortKey' => 'status_id', 'icons' => [
                QuestStatus::ongoing->value => ['icon' => 'fa-regular fa-hourglass', 'tooltip' => __('quests.hints.is_ongoing')],
                QuestStatus::abandoned->value => ['icon' => 'fa-regular fa-ban', 'tooltip' => __('quests.hints.is_abandoned')],
                QuestStatus::completed->value => ['icon' => 'fa-regular fa-check-circle', 'tooltip' => __('quests.hints.is_completed')],
            ]],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'instigator', 'type' => 'entity', 'label' => __('quests.fields.instigator'), 'sortable' => false],
            ['key' => 'locations', 'type' => 'entities', 'label' => __('entities.locations'), 'sortable' => false, 'moduleGate' => 'locations'],
            ['key' => 'elements_count', 'type' => 'count', 'label' => __('quests.show.tabs.elements'), 'sortable' => false],
            ['key' => 'calendar_date', 'type' => 'calendar_date', 'label' => __('crud.fields.calendar_date'), 'sortable' => true],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => true],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function calendar(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => true],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function map(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'explore', 'type' => 'explore', 'label' => __('maps.actions.explore'), 'sortable' => false],
            ['key' => 'location', 'type' => 'entity', 'label' => __('entities.location'), 'sortable' => true, 'sortKey' => 'location.name', 'moduleGate' => 'locations'],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => true],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function whiteboard(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'draw', 'type' => 'draw', 'label' => __('whiteboards.actions.draw'), 'sortable' => false],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => true],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function timeline(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'eras_count', 'type' => 'count', 'label' => __('timelines.fields.eras'), 'sortable' => false],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => true],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function race(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'is_extinct', 'type' => 'icon', 'label' => __('creatures.fields.is_extinct'), 'sortable' => true, 'icon' => 'fa-regular fa-skull-cow', 'tooltip' => __('creatures.fields.is_extinct')],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => true],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function creature(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'locations', 'type' => 'entities', 'label' => __('entities.locations'), 'sortable' => false, 'moduleGate' => 'locations'],
            ['key' => 'is_extinct', 'type' => 'icon', 'label' => __('creatures.fields.is_extinct'), 'sortable' => true, 'icon' => 'fa-regular fa-skull-cow', 'tooltip' => __('creatures.fields.is_extinct')],
            ['key' => 'is_dead', 'type' => 'icon', 'label' => __('characters.fields.is_dead'), 'sortable' => true, 'icon' => 'fa-regular fa-skull', 'tooltip' => __('characters.fields.is_dead')],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => true],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function item(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'price', 'type' => 'text', 'label' => __('items.fields.price'), 'sortable' => true],
            ['key' => 'size', 'type' => 'text', 'label' => __('items.fields.size'), 'sortable' => true],
            ['key' => 'weight', 'type' => 'text', 'label' => __('items.fields.weight'), 'sortable' => true],
            ['key' => 'location', 'type' => 'entity', 'label' => __('entities.location'), 'sortable' => true, 'sortKey' => 'location.name', 'moduleGate' => 'locations'],
            ['key' => 'creators', 'type' => 'entities', 'label' => __('items.fields.creators'), 'sortable' => false],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => true],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function event(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'date', 'type' => 'text', 'label' => __('events.fields.date'), 'sortable' => true],
            ['key' => 'locations', 'type' => 'entities', 'label' => __('entities.locations'), 'sortable' => false, 'moduleGate' => 'locations'],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => true],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function note(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => true],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function ability(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'entities_count', 'type' => 'count', 'label' => __('entities.entries'), 'sortable' => false],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => true],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function attributeTemplate(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'entity_type_name', 'type' => 'text', 'label' => __('attribute_templates.fields.auto_apply'), 'sortable' => false],
            ['key' => 'is_enabled', 'type' => 'icon', 'label' => __('attribute_templates.fields.is_enabled'), 'sortable' => true, 'icon' => 'fa-regular fa-wand-magic', 'tooltip' => __('attribute_templates.fields.is_enabled')],
            ['key' => 'attributes_count', 'type' => 'count', 'label' => __('entities.properties'), 'sortable' => false],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => true],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function tag(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'colour', 'type' => 'text', 'label' => __('crud.fields.colour'), 'sortable' => true],
            ['key' => 'entities_count', 'type' => 'count', 'label' => __('tags.fields.children'), 'sortable' => false],
            ['key' => 'is_auto_applied', 'type' => 'icon', 'label' => __('attribute_templates.fields.auto_apply'), 'sortable' => true, 'icon' => 'fa-regular fa-wand-magic', 'tooltip' => __('tags.fields.is_auto_applied')],
            ['key' => 'is_hidden', 'type' => 'icon', 'label' => __('campaigns.privacy.hidden'), 'sortable' => true, 'icon' => 'fa-regular fa-eye-slash', 'tooltip' => __('tags.fields.is_hidden')],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => true],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }
}
