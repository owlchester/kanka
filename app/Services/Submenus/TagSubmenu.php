<?php

namespace App\Services\Submenus;

use App\Models\Tag;

class TagSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];

        /** @var Tag $model */
        $model = $this->entity->child;

        return $items;
    }
}
