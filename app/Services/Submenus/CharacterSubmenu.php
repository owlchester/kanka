<?php

namespace App\Services\Submenus;

use App\Facades\Module;

class CharacterSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        $canEdit = auth()->check() && auth()->user()->can('update', $this->entity);

        $items['second']['profile'] = [
            'name' => 'entities/profile.show.tab_name',
            'route' => 'entities.profile',
            'entity' => true,

            'button' => $canEdit ? [
                'url' => $this->entity->url('edit'),
                'icon' => 'fa-solid fa-pencil',
                'tooltip' => __('entities/profile.actions.edit_profile'),
            ] : null,
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
