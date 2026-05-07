<?php

namespace App\Services\Submenus;

use App\Models\Family;

class FamilySubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        /** @var Family $family */
        $family = $this->entity->child;

        if (config('services.stripe.enabled') && config('limits.campaigns.premium')) {
            $items['second']['tree'] = [
                'name' => __('families.show.tabs.tree'),
                'route' => 'families.family-tree',
            ];
        }

        return $items;
    }
}
