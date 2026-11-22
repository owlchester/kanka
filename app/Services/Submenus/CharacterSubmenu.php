<?php

namespace App\Services\Submenus;

use App\Facades\Module;

class CharacterSubmenu extends BaseSubmenu
{
    public function extra(): array
    {
        $items = [];
        $canEdit = isset($this->user) && $this->user->can('update', $this->entity);

        $items['second']['profile'] = [
            'name' => __('entities/profile.show.tab_name'),
            'route' => 'entities.profile',
            'entity' => true,
        ];

        // @phpstan-ignore-next-line
        $count = $this->entity->child->organisationMemberships()->has('organisation')->has('organisation.entity')->count();
        if ($this->campaign->enabled('organisations') && ($count > 0 || $canEdit)) {
            $items['second']['organisations'] = [
                'name' => Module::plural(config('entities.ids.organisation'), 'entities.organisations'),
                'route' => 'characters.organisations',
                'count' => $count,
            ];
        }

        return $items;
    }
}
