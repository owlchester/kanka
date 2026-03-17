<?php

namespace App\Services\Submenus;

use App\Models\Organisation;

class OrganisationSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        /** @var Organisation $model */
        $model = $this->entity->child;

        $count = $model->allMembersCount();
        if ($this->campaign->enabled('characters') && $count > 0) {
            $items['second']['members'] = [
                'name' => __('organisations.fields.members'),
                'route' => 'organisations.members',
                'count' => $count,
            ];
        }

        return $items;
    }
}
