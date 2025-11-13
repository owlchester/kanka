<?php

namespace App\Services\Submenus;

use App\Models\Map;

class MapSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        /** @var Map $map */
        $map = $this->entity->child;
        $items['second']['maps'] = [
            'name' => $this->entity->entityType->plural(),
            'route' => 'maps.maps',
            'count' => $map->descendants()->has('entity')->count(),
        ];
        if (isset($this->user) && $this->user->can('update', $this->entity)) {
            $items['second']['layers'] = [
                'name' => __('maps.panels.layers'),
                'route' => 'maps.map_layers.index',
                'count' => $map->layers->count(),
            ];
            $items['second']['groups'] = [
                'name' => __('maps.panels.groups'),
                'route' => 'maps.map_groups.index',
                'count' => $map->groups->count(),
            ];
            $items['second']['markers'] = [
                'name' => __('maps.panels.markers'),
                'route' => 'maps.map_markers.index',
                'count' => $map->markers->count(),
            ];
        }

        return $items;
    }
}
