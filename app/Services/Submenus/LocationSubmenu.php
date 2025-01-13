<?php

namespace App\Services\Submenus;

use App\Facades\Module;
use App\Models\Location;

class LocationSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        /** @var Location $location */
        $location = $this->entity->child;

        $count = $location->descendants()->has('parent')->count();
        if ($count > 0) {
            $items['second']['locations'] = [
                'name' => Module::plural($location->entityTypeId(), 'entities.locations'),
                'route' => 'locations.locations',
                'count' => $count
            ];
        }

        $count = $location->allCharacters()->count();
        if ($this->campaign->enabled('characters') && $count > 0) {
            $items['second']['characters'] = [
                'name' => Module::plural(config('entities.ids.character'), 'entities.characters'),
                'route' => 'locations.characters',
                'count' => $count
            ];
        }
        return $items;
    }
}
