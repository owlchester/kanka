<?php

namespace App\Services\Submenus;

use App\Facades\Module;

class MapSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        $items['second']['maps'] = [
            'name' => Module::plural($this->model->entityTypeId(), 'entities.maps'),
            'route' => 'maps.maps',
            'count' => $this->model->maps()->count()
        ];
        if (auth()->check() && auth()->user()->can('update', $this->model)) {
            $items['second']['layers'] = [
                'name' => 'maps.panels.layers',
                'route' => 'maps.map_layers.index',
                'count' => $this->model->layers->count()
            ];
            $items['second']['groups'] = [
                'name' => 'maps.panels.groups',
                'route' => 'maps.map_groups.index',
                'count' => $this->model->groups->count()
            ];
            $items['second']['markers'] = [
                'name' => 'maps.panels.markers',
                'route' => 'maps.map_markers.index',
                'count' => $this->model->markers->count()
            ];
        }
        return $items;
    }
}
