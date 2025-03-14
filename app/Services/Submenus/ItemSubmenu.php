<?php

namespace App\Services\Submenus;

use App\Facades\Module;
use App\Models\Item;

class ItemSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        /** @var Item $item */
        $item = $this->entity->child;
        $items['second']['items'] = [
            'name' => Module::plural($item->entityTypeId(), 'entities.items'),
            'route' => 'items.items',
            'count' => $item->descendants()->has('entity')->count()
        ];

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
