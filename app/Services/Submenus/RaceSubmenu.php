<?php

namespace App\Services\Submenus;

use App\Facades\Module;

class RaceSubmenu  extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        $count = $this->model->descendants()->count();
        if ($count > 0) {
            $items['second']['races'] = [
                'name' => Module::plural($this->model->entityTypeId(), 'entities.races'),
                'route' => 'races.races',
                'count' => $count
            ];
        }
        return $items;
    }
}
