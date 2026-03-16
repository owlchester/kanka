<?php

namespace App\Services\Entity;

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
     * @return array<string, string> Column key => child relation name for withCount
     */
    public function countMap(EntityType $entityType, Campaign $campaign): array
    {
        $countRelations = [
            'members_count' => $entityType->code . '.members',
            'elements_count' => $entityType->code . '.elements',
            'eras_count' => $entityType->code . '.eras',
            'entities_count' => $entityType->code . '.entities',
        ];

        $map = [];
        foreach ($this->columns($entityType, $campaign) as $col) {
            if (isset($countRelations[$col['key']])) {
                $map[$col['key']] = $countRelations[$col['key']];
            }
        }

        return $map;
    }

    protected function typeRelations(): array
    {
        return [
            'families' => ['character.characterFamilies.family.entity'],
            'races' => ['character.characterRaces.race.entity'],
            'locations' => ['locations.entity'],
            'location' => ['location.entity'],
            'calendar_date' => ['calendarDate.calendar.entity'],
            'author' => ['journal.author.entity'],
            'organisation' => ['organisation.entity'],
            'character' => ['character.entity'],
            'parent' => ['parent.entity'],
            'instigator' => ['quest.instigator.entity'],
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
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => false],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function characters(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'title', 'type' => 'text', 'label' => __('characters.fields.title'), 'sortable' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'status', 'type' => 'icon', 'label' => __('characters.fields.status'), 'sortable' => true, 'icon' => 'fa-regular fa-skull', 'tooltip' => __('characters.hints.is_dead')],
            ['key' => 'families', 'type' => 'entities', 'label' => __('entities.families'), 'sortable' => false, 'moduleGate' => 'families'],
            ['key' => 'locations', 'type' => 'entities', 'label' => __('entities.locations'), 'sortable' => false, 'moduleGate' => 'locations'],
            ['key' => 'races', 'type' => 'entities', 'label' => __('entities.races'), 'sortable' => false, 'moduleGate' => 'races'],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => false],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function locations(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'title', 'type' => 'text', 'label' => __('locations.fields.title'), 'sortable' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'is_destroyed', 'type' => 'icon', 'label' => __('locations.fields.is_destroyed'), 'sortable' => true, 'icon' => 'fa-regular fa-building-circle-xmark', 'tooltip' => __('locations.fields.is_destroyed')],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => false],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function organisations(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'locations', 'type' => 'entities', 'label' => __('entities.locations'), 'sortable' => false, 'moduleGate' => 'locations'],
            ['key' => 'members_count', 'type' => 'count', 'label' => __('organisations.fields.members'), 'sortable' => false, 'moduleGate' => 'characters'],
            ['key' => 'is_defunct', 'type' => 'icon', 'label' => __('organisations.fields.is_defunct'), 'sortable' => true, 'icon' => 'fa-regular fa-skull', 'tooltip' => __('organisations.fields.is_defunct')],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => false],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function families(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'location', 'type' => 'entity', 'label' => __('entities.location'), 'sortable' => true, 'sortKey' => 'location.name', 'moduleGate' => 'locations'],
            ['key' => 'members_count', 'type' => 'count', 'label' => __('organisations.fields.members'), 'sortable' => false],
            ['key' => 'is_extinct', 'type' => 'icon', 'label' => __('creatures.fields.is_extinct'), 'sortable' => true, 'icon' => 'fa-regular fa-skull', 'tooltip' => __('creatures.fields.is_extinct')],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => false],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function journals(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'date', 'type' => 'text', 'label' => __('journals.fields.date'), 'sortable' => true],
            ['key' => 'calendar_date', 'type' => 'calendar_date', 'label' => __('crud.fields.calendar_date'), 'sortable' => true],
            ['key' => 'author', 'type' => 'entity', 'label' => __('journals.fields.author'), 'sortable' => true, 'sortKey' => 'journal.author_id'],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => false],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function quests(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'instigator', 'type' => 'entity', 'label' => __('quests.fields.instigator'), 'sortable' => false],
            ['key' => 'locations', 'type' => 'entities', 'label' => __('entities.locations'), 'sortable' => false, 'moduleGate' => 'locations'],
            ['key' => 'elements_count', 'type' => 'count', 'label' => __('quests.fields.elements'), 'sortable' => false],
            ['key' => 'calendar_date', 'type' => 'calendar_date', 'label' => __('crud.fields.calendar_date'), 'sortable' => true],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => false],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function calendars(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => false],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function maps(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'location', 'type' => 'entity', 'label' => __('entities.location'), 'sortable' => true, 'sortKey' => 'location.name', 'moduleGate' => 'locations'],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => false],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function timelines(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'eras_count', 'type' => 'count', 'label' => __('timelines.fields.eras'), 'sortable' => false],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => false],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function races(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'is_extinct', 'type' => 'icon', 'label' => __('creatures.fields.is_extinct'), 'sortable' => true, 'icon' => 'fa-regular fa-skull-cow', 'tooltip' => __('creatures.fields.is_extinct')],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => false],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function creatures(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'locations', 'type' => 'entities', 'label' => __('entities.locations'), 'sortable' => false, 'moduleGate' => 'locations'],
            ['key' => 'is_extinct', 'type' => 'icon', 'label' => __('creatures.fields.is_extinct'), 'sortable' => true, 'icon' => 'fa-regular fa-skull-cow', 'tooltip' => __('creatures.fields.is_extinct')],
            ['key' => 'is_dead', 'type' => 'icon', 'label' => __('characters.fields.is_dead'), 'sortable' => true, 'icon' => 'fa-regular fa-skull', 'tooltip' => __('characters.fields.is_dead')],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => false],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function items(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'price', 'type' => 'text', 'label' => __('items.fields.price'), 'sortable' => true],
            ['key' => 'size', 'type' => 'text', 'label' => __('items.fields.size'), 'sortable' => true],
            ['key' => 'location', 'type' => 'entity', 'label' => __('entities.location'), 'sortable' => true, 'sortKey' => 'location.name', 'moduleGate' => 'locations'],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => false],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function events(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'date', 'type' => 'text', 'label' => __('events.fields.date'), 'sortable' => true],
            ['key' => 'locations', 'type' => 'entities', 'label' => __('entities.locations'), 'sortable' => false, 'moduleGate' => 'locations'],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => false],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function notes(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => false],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function abilities(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'entities_count', 'type' => 'count', 'label' => __('abilities.fields.entities'), 'sortable' => false],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => false],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }

    protected function tags(): array
    {
        return [
            ['key' => 'avatar', 'type' => 'avatar', 'sortable' => false, 'alwaysVisible' => true],
            ['key' => 'name', 'type' => 'name', 'label' => __('crud.fields.name'), 'sortable' => true, 'alwaysVisible' => true],
            ['key' => 'type', 'type' => 'text', 'label' => __('crud.fields.type'), 'sortable' => true],
            ['key' => 'parent', 'type' => 'entity', 'label' => __('crud.fields.parent'), 'sortable' => true, 'sortKey' => 'parent.name'],
            ['key' => 'colour', 'type' => 'text', 'label' => __('crud.fields.colour'), 'sortable' => true],
            ['key' => 'entities_count', 'type' => 'count', 'label' => __('tags.fields.children'), 'sortable' => false],
            ['key' => 'is_auto_applied', 'type' => 'icon', 'label' => __('tags.fields.is_auto_applied'), 'sortable' => true, 'icon' => 'fa-regular fa-wand-magic', 'tooltip' => __('tags.fields.is_auto_applied')],
            ['key' => 'is_hidden', 'type' => 'icon', 'label' => __('tags.fields.is_hidden'), 'sortable' => true, 'icon' => 'fa-regular fa-eye-slash', 'tooltip' => __('tags.fields.is_hidden')],
            ['key' => 'tags', 'type' => 'tags', 'label' => __('entities.tags'), 'sortable' => false],
            ['key' => 'is_private', 'type' => 'private', 'label' => __('crud.fields.is_private'), 'sortable' => true, 'adminOnly' => true],
        ];
    }
}
