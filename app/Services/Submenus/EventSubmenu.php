<?php

namespace App\Services\Submenus;

use App\Models\Event;

class EventSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];

        return $items;
    }
}
