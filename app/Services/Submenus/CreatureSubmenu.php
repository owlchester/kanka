<?php

namespace App\Services\Submenus;

use App\Models\Creature;

class CreatureSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];

        return $items;
    }
}
