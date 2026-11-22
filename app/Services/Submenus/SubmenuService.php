<?php

namespace App\Services\Submenus;

use App\Facades\Module;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use App\Traits\UserAware;
use Illuminate\Support\Arr;

class SubmenuService
{
    use CampaignAware;
    use EntityAware;
    use UserAware;

    protected array $items = [];

    protected array $ordered;

    public function items(): array
    {
        return $this->default()
            ->custom()
            ->ordered();
    }

    protected function default(): self
    {
        $this->items['first']['story'] = [
            'name' => __('crud.tabs.overview'),
            'route' => 'entities.show',
            'entity' => true,
        ];

        $childCount = $this->entity->children()->count();
        if ($childCount > 0) {
            $this->items['second']['children'] = [
                'name' => __('entities/children.title'),
                'route' => 'entities.children',
                'count' => $childCount,
                'entity' => true,
            ];
        }

        // Each entity can have relations
        $this->items['first']['relations'] = [
            'name' => __('entries/tabs.relations'),
            'route' => 'entities.relations.index',
            'count' => $this->entity->relationships()->has('target')->count(),
            'entity' => true,
            'icon' => 'fa-regular fa-users',
        ];

        // Each entity can have abilities
        if ($this->campaign->enabled('abilities') && ! $this->entity->isAbility()) {
            $this->items['third']['abilities'] = [
                'name' => Module::plural(config('entities.ids.ability'), 'crud.tabs.abilities'),
                'route' => 'entities.entity_abilities.index',
                'count' => 0, // $this->entity->abilities()->has('ability')->count(),
                'entity' => true,
                'icon' => 'ra ra-fire-symbol',
            ];
        }

        if ($this->campaign->enabled('calendars')) {
            $this->items['third']['reminders'] = [
                'name' => __('crud.tabs.reminders'),
                'route' => 'entities.reminders.index',
                'count' => 0, // $this->entity->abilities()->has('ability')->count(),
                'entity' => true,
                'icon' => 'ra ra-sun-moon',
            ];
        }

        if ($this->campaign->enabled('entity_attributes')) {
            $this->items['third']['attributes'] = [
                'name' => __('entries/tabs.properties'),
                'route' => 'entities.attributes',
                'entity' => true,
                'icon' => '',
                'perm' => 'view-attributes',
            ];
        }

        // Each entity can have an inventory
        if ($this->campaign->enabled('inventories')) {
            $this->items['third']['inventory'] = [
                'name' => __('crud.tabs.inventory'),
                'route' => 'entities.inventory',
                'count' => 0, // $this->entity->inventories()->has('item')->count(),
                'entity' => true,
                'icon' => 'ra ra-round-bottom-flask',
            ];
        }

        // Each entity can have assets
        if ($this->campaign->enabled('media') && $this->entity->hasFiles()) {
            $this->items['third']['assets'] = [
                'name' => __('entries/tabs.media'),
                'route' => 'entities.entity_assets.index',
                'count' => $this->entity->assets()->withoutAliases()->count(),
                'entity' => true,
                'icon' => 'fa-regular fa-file',
            ];
        }

        // Check if and how many times entity has been mentioned
        $mentionsCount = $this->entity->mentionsCount();
        if (isset($this->user) && $mentionsCount > 0) {
            $this->items['fourth']['mentions'] = [
                'name' => __('crud.tabs.mentions'),
                'route' => 'entities.mentions',
                'entity' => true,
                'count' => $mentionsCount,
            ];
        }

        return $this;
    }

    protected function custom(): self
    {
        $type = $this->entity->entityType;
        $class = match ($type->code) {
            'ability' => AbilitySubmenu::class,
            'calendar' => CalendarSubmenu::class,
            'character' => CharacterSubmenu::class,
            'event' => EventSubmenu::class,
            'family' => FamilySubmenu::class,
            'item' => ItemSubmenu::class,
            'location' => LocationSubmenu::class,
            'map' => MapSubmenu::class,
            'organisation' => OrganisationSubmenu::class,
            'quest' => QuestSubmenu::class,
            'timeline' => TimelineSubmenu::class,
            default => null,
        };
        if ($type->isCustom() || $class === null) {
            return $this;
        }

        $service = app($class)->entity($this->entity)->campaign($this->campaign);
        if (isset($this->user)) {
            $service->user($this->user);
        }

        foreach ($service->extra() as $section => $sectionItems) {
            $this->items[$section] = array_merge($this->items[$section] ?? [], $sectionItems);
        }

        return $this;
    }

    protected function ordered(): array
    {
        $this->ordered = [];
        if (Arr::has($this->items, 'first')) {
            $this->ordered[] = $this->items['first'];
        }
        if (Arr::has($this->items, 'second')) {
            $this->ordered[] = $this->items['second'];
        }
        if (Arr::has($this->items, 'third')) {
            $sortedItems = array_combine(array_keys($this->items['third']), array_column($this->items['third'], 'name'));
            foreach ($sortedItems as $key => $item) {
                $sortedItems[$key] = $item;
            }

            $collator = new \Collator(app()->getLocale());
            $collator->asort($sortedItems);

            $sortedMenuItems = [];
            foreach ($sortedItems as $key => $item) {
                $sortedMenuItems[$key] = $this->items['third'][$key];
            }

            $this->ordered[] = $sortedMenuItems;
        }
        if (Arr::has($this->items, 'fourth')) {
            $this->ordered[] = $this->items['fourth'];
        }

        return $this->ordered;
    }
}
