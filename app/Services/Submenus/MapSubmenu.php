<?php

namespace App\Services\Submenus;

use App\Facades\Module;
use App\Models\Map;

class MapSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        /** @var Map $map */
        $map = $this->entity->child;
        $items['second']['maps'] = [
            'name' => Module::plural($map->entityTypeId(), 'entities.maps'),
            'route' => 'maps.maps',
            'count' => $map->descendants()->has('entity')->count()
        ];
        if (auth()->check() && auth()->user()->can('update', $this->entity)) {
            $items['second']['layers'] = [
                'name' => 'maps.panels.layers',
                'route' => 'maps.map_layers.index',
                'count' => $map->layers->count()
            ];
            $items['second']['groups'] = [
                'name' => 'maps.panels.groups',
                'route' => 'maps.map_groups.index',
                'count' => $map->groups->count()
            ];
            $items['second']['markers'] = [
                'name' => 'maps.panels.markers',
                'route' => 'maps.map_markers.index',
                'count' => $map->markers->count()
            ];
        }
        return $items;
    }
}
