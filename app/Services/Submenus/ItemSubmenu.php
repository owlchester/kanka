<?php

namespace App\Services\Submenus;

class ItemSubmenu  extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        $inventoryCount = $this->model->inventories()->with('item')->has('entity')->count();
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
