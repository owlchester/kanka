<?php

namespace App\Services\Submenus;

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
                'name' => $this->entity->entityType->plural(),
                'route' => 'creatures.creatures',
                'count' => $count,
            ];
        }

        return $items;
    }
}
