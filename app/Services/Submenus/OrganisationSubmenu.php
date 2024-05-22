<?php

namespace App\Services\Submenus;

use App\Facades\Module;

class OrganisationSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];

        $count = $this->model->descendants()->count();
        if ($count > 0) {
            $items['second']['organisations'] = [
                'name' => Module::plural($this->model->entityTypeId(), 'entities.organisations'),
                'route' => 'organisations.organisations',
                'count' => $count,
            ];
        }
        return $items;
    }
}
