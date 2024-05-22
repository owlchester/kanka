<?php

namespace App\Services\Submenus;

use App\Facades\Module;

class EventSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        $items['second']['events'] = [
            'name' => Module::plural($this->model->entityTypeId(), 'entities.events'),
            'route' => 'events.events',
            'count' => $this->model->descendants()->count()
        ];
        return $items;
    }
}
