<?php

namespace App\Services\Submenus;

use App\Models\Race;

class RaceSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        /** @var Race $model */
        $model = $this->entity->child;
        $count = $model->descendants()->has('entity')->count();
        if ($count > 0) {
            $items['second']['races'] = [
                'name' => $this->entity->entityType->plural(),
                'route' => 'races.races',
                'count' => $count,
            ];
        }

        return $items;
    }
}
