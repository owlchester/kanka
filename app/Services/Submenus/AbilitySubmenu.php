<?php

namespace App\Services\Submenus;

use App\Facades\Module;
use App\Models\Ability;

class AbilitySubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        /** @var Ability $ability */
        $ability = $this->entity->child;
        $items['second']['abilities'] = [
            'name' => Module::plural($ability->entityTypeId(), 'entities.abilities'),
            'route' => 'abilities.abilities',
            'count' => $ability->descendants()->count()
        ];
        $items['second']['entities'] = [
            'name' => 'abilities.show.tabs.entities',
            'route' => 'abilities.entities',
            'count' => $ability->entities()->count()
        ];
        return $items;
    }
}
