<?php

namespace App\Services\Submenus;

use App\Models\Ability;

class AbilitySubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        /** @var Ability $ability */
        $ability = $this->entity->child;
        $items['second']['abilities'] = [
            'name' => $this->entity->entityType->plural(),
            'route' => 'abilities.abilities',
            'count' => $ability->descendants()->has('entity')->count(),
        ];
        $items['second']['entities'] = [
            'name' => __('abilities.show.tabs.entities'),
            'route' => 'abilities.entities',
            'count' => $ability->entities()->count(),
        ];

        return $items;
    }
}
