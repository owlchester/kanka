<?php

namespace App\Services\Submenus;

use App\Facades\CampaignLocalization;
use App\Facades\Module;

class LocationSubmenu  extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];

        $count = $this->model->descendants()->has('location')->count();
        if ($count > 0) {
            $items['second']['locations'] = [
                'name' => Module::plural($this->model->entityTypeId(), 'entities.locations'),
                'route' => 'locations.locations',
                'count' => $count
            ];
        }

        $count = $this->model->allCharacters()->count();
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
