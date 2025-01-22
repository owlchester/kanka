<?php

namespace App\Services\Submenus;

class CustomSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        $childCount = $this->entity->children()->count();
        if ($childCount > 0) {
            $items['second']['children'] = [
                'name' => 'entities/children.title',
                'route' => 'entities.children',
                'count' => $childCount,
                'entity' => true,
            ];
        }

        return $items;
    }
}
