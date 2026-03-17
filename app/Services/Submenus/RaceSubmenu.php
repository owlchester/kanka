<?php

namespace App\Services\Submenus;

use App\Models\Race;

class RaceSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];

        return $items;
    }
}
