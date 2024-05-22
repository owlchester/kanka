<?php

namespace App\Services\Submenus;

use App\Facades\Module;

class CreatureSubmenu  extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        $count = $this->model->descendants()->count();
        if ($count > 0) {
            $items['second']['creatures'] = [
                'name' => Module::plural($this->model->entityTypeId(), 'entities.creatures'),
                'route' => 'creatures.creatures',
                'count' => $count
            ];
        }
        return $items;
    }
}
