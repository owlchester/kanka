<?php

namespace App\Services\Submenus;

use App\Facades\Module;

class FamilySubmenu  extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        $items['second']['families'] = [
            'name' => Module::plural($this->model->entityTypeId(), 'entities.families'),
            'route' => 'families.families',
            'count' => $this->model->descendants()->count()
        ];

        if (config('services.stripe.enabled')) {
            $items['second']['tree'] = [
                'name' => 'families.show.tabs.tree',
                'route' => 'families.family-tree',
            ];
        }
        return $items;
    }
}
