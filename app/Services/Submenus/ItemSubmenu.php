<?php

namespace App\Services\Submenus;

use App\Models\Item;

class ItemSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        /** @var Item $item */
        $item = $this->entity->child;
        $inventoryCount = $item->inventories()->with('item')->has('entity')->count();
        if ($inventoryCount > 0) {
            $items['second']['inventories'] = [
                'name' => 'items.show.tabs.inventories',
                'route' => 'items.inventories',
                'count' => $inventoryCount
            ];
        }

        return $items;
    }
}
