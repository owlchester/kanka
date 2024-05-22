<?php

namespace App\Services\Submenus;

use App\Facades\Module;

class TagSubmenu  extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];

        $count = $this->model->descendants->count();
        if ($count > 0) {
            $items['second']['tags'] = [
                'name' => Module::plural($this->model->entityTypeId(), 'entities.tags'),
                'route' => 'tags.tags',
                'count' => $count,
            ];
        }
        return $items;
    }
}
