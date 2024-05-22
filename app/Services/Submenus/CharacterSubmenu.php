<?php

namespace App\Services\Submenus;

use App\Facades\Module;
use App\Models\Character;

class CharacterSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        /** @var Character $character */
        $character = $this->model;
        $canEdit = auth()->check() && auth()->user()->can('update', $character);

        $items['second']['profile'] = [
            'name' => 'entities/profile.show.tab_name',
            'route' => 'entities.profile',
            'entity' => true,

            'button' => auth()->check() && auth()->user()->can('update', $character) ? [
                'url' => $character->getLink('edit'),
                'icon' => 'fa-solid fa-pencil',
                'tooltip' => __('crud.edit'),
            ] : null,
        ];

        $count = $character->organisationMemberships()->has('organisation')->count();
        if ($this->campaign->enabled('organisations') && ($count > 0 || $canEdit)) {
            $items['second']['organisations'] = [
                'name' => Module::plural(config('entities.ids.organisation'), 'entities.organisations'),
                'route' => 'characters.organisations',
                'count' => $count
            ];
        }
        return $items;
    }
}
