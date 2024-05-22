<?php

namespace App\Services\Submenus;

use App\Facades\Module;

class AbilitySubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        $items['second']['abilities'] = [
            'name' => Module::plural($this->model->entityTypeId(), 'entities.abilities'),
            'route' => 'abilities.abilities',
            'count' => $this->model->descendants()->count()
        ];
        $items['second']['entities'] = [
            'name' => 'abilities.show.tabs.entities',
            'route' => 'abilities.entities',
            'count' => $this->model->entities()->count()
        ];
        return $items;
    }
}
