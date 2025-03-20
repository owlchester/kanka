<?php

namespace App\Services\Submenus;

use App\Facades\Module;
use App\Models\Family;

class FamilySubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        /** @var Family $family */
        $family = $this->entity->child;
        $items['second']['families'] = [
            'name' => Module::plural($family->entityTypeId(), 'entities.families'),
            'route' => 'families.families',
            'count' => $family->descendants()->has('entity')->count(),
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
