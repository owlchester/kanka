<?php

namespace App\Services\Submenus;

class CustomSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];

        return $items;
    }
}
