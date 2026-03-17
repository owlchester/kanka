<?php

namespace App\Services\Submenus;

use App\Models\Journal;

class JournalSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];

        return $items;
    }
}
