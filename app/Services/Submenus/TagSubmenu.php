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
        $count = $model->descendants->count();
        if ($count > 0) {
            $items['second']['tags'] = [
                'label' => $this->entity->entityType->plural(),
                'route' => 'tags.tags',
                'count' => $count,
            ];
        }

        return $items;
    }
}
