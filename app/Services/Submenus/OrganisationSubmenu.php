<?php

namespace App\Services\Submenus;

use App\Facades\Module;
use App\Models\Organisation;

class OrganisationSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        /** @var Organisation $model */
        $model = $this->entity->child;
        $count = $model->descendants()->has('entity')->count();
        if ($count > 0) {
            $items['second']['organisations'] = [
                'name' => Module::plural($model->entityTypeId(), 'entities.organisations'),
                'route' => 'organisations.organisations',
                'count' => $count,
            ];
        }

        return $items;
    }
}
