<?php

namespace App\Services\Submenus;

use App\Facades\Module;
use App\Models\MiscModel;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SubmenuService
{
    use CampaignAware;
    use EntityAware;

    protected Model|MiscModel $model;
    protected array $items = [];
    protected array $ordered;

    public function model(Model|MiscModel $model): self
    {
        $this->model = $model;
        return $this;
    }

    public function items(): array
    {
        return $this->default()
            ->custom()
            ->ordered();
    }

    protected function default(): self
    {
        $this->items['first']['story'] = [
            'name' => 'crud.tabs.story',
            'route' => 'entities.show',
            'entity' => true,
            'button' => auth()->check() && auth()->user()->can('update', $this->model) ? [
                'url' => route('entities.story.reorder', [$this->campaign, $this->entity->id]),
                'icon' => 'fa-solid fa-arrow-up-arrow-down',
                'tooltip' => __('entities/story.reorder.icon_tooltip'),
            ] : null,
        ];


        // Each entity can have relations
        if (!isset($this->model->hasRelations) || $this->model->hasRelations === true) {
            $this->items['first']['relations'] = [
                'name' => 'crud.tabs.connections',
                'route' => 'entities.relations.index',
                'count' => $this->entity->relationships()->has('target')->count(),
                'entity' => true,
                'icon' => 'fa-solid fa-users',
            ];
        }

        // Each entity can have abilities
        // @phpstan-ignore-next-line
        if ($this->campaign->enabled('abilities') && $this->model->entityTypeId() != config('entities.ids.ability')) {
            $this->items['third']['abilities'] = [
                'name' => Module::plural(config('entities.ids.ability'), 'crud.tabs.abilities'),
                'route' => 'entities.entity_abilities.index',
                'count' => 0, //$this->entity->abilities()->has('ability')->count(),
                'entity' => true,
                'icon' => 'ra ra-fire-symbol',
            ];
        }

        if ($this->campaign->enabled('calendars')) {
            $this->items['third']['reminders'] = [
                'name' => 'crud.tabs.reminders',
                'route' => 'entities.entity_events.index',
                'count' => 0, //$this->entity->abilities()->has('ability')->count(),
                'entity' => true,
                'icon' => 'ra ra-sun-moon',
            ];
        }

        if ($this->campaign->enabled('entity_attributes')) {
            $this->items['third']['attributes'] = [
                'name' => 'crud.tabs.attributes',
                'route' => 'entities.attributes',
                'entity' => true,
                'icon' => '',
                'perm' => 'view-attributes'
            ];
        }

        // Each entity can have an inventory
        if ($this->campaign->enabled('inventories')) {
            $this->items['third']['inventory'] = [
                'name' => 'crud.tabs.inventory',
                'route' => 'entities.inventory',
                'count' => 0, //$this->entity->inventories()->has('item')->count(),
                'entity' => true,
                'icon' => 'ra ra-round-bottom-flask',
            ];
        }


        // Each entity can have assets
        if ($this->campaign->enabled('assets') && $this->entity->hasFiles()) {
            $this->items['third']['assets'] = [
                'name' => 'crud.tabs.assets',
                'route' => 'entities.entity_assets.index',
                'count' => $this->entity->assets()->filtered($this->campaign->boosted())->count(),
                'entity' => true,
                'icon' => 'fa-solid fa-file',
            ];
        }

        // Check if and how many times entity has been mentioned
        $mentionsCount = $this->entity->mentionsCount();
        if (auth()->check() && $mentionsCount > 0) {
            $this->items['fourth']['mentions'] = [
                'name' => 'crud.tabs.mentions',
                'route' => 'entities.mentions',
                'entity' => true,
                'count' => $mentionsCount,
                'icon' => 'fa-solid fa-lock',
            ];
        }

        // Permissions for the admin?
        if (auth()->check() && auth()->user()->can('permission', $this->model)) {
            $this->items['fourth']['permissions'] = [
                'name' => 'crud.tabs.permissions',
                'route' => 'entities.permissions',
                'entity' => true,
                'icon' => 'fa-solid fa-lock',
                'ajax' => true,
                'id' => 'entity-permissions-link'
            ];
        }

        return $this;
    }
    protected function custom(): self
    {
        // Get the custom one based on the model name?
        $className = Str::afterLast(get_class($this->model), '\\');
        $submenuName = 'App\Services\Submenus\\' . $className . 'Submenu';
        try {
            /** @var CharacterSubmenu $object */
            $object = app()->make($submenuName);
            // @phpstan-ignore-next-line
            $this->items += $object->model($this->model)->campaign($this->campaign)->extra();
        } catch (\Exception $e) {
            // Some modules like convos have no submenu
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
                $sortedItems[$key] = __($item);
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
