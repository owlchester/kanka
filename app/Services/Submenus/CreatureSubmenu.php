<?php

namespace App\Services\Submenus;

use App\Facades\Module;
use App\Models\Creature;

class CreatureSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        /** @var Creature $creature */
        $creature = $this->entity->child;
        $count = $creature->descendants()->has('entity')->count();
        if ($count > 0) {
            $items['second']['creatures'] = [
                'name' => Module::plural($creature->entityTypeId(), 'entities.creatures'),
                'route' => 'creatures.creatures',
                'count' => $count,
            ];
        }

        return $items;
    }
}
