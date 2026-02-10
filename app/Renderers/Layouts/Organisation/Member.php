<?php

namespace App\Renderers\Layouts\Organisation;

use App\Facades\Module;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Member extends Layout
{
    /**
     * Available columns
     *
     * @return array[]
     */
    public function columns(): array
    {
        $columns = [
            'image' => [
                'render' => Standard::IMAGE,
                'with' => ['target' => 'character'],
            ],
            'character' => [
                'key' => 'character.name',
                'label' => Module::singular(config('entities.ids.character'), 'entities.character'),
                'render' => Standard::CHARACTER,
            ],
            'role' => [
                'key' => 'role',
                'label' => 'organisations.members.fields.role',
                'render' => function ($model) {
                    $icon = '';
                    if ($model->inactive()) {
                        $icon = '<i class="fa-regular fa-user-slash" data-title="' . __('organisations.members.status.inactive') . '" data-toggle="tooltip"></i>';
                    } elseif ($model->unknown()) {
                        $icon = '<i class="fa-regular fa-question" data-title="' . __('organisations.members.status.unknown') . '" data-toggle="tooltip"></i>';
                    }
                    $private = '';
                    if ($model->is_private) {
                        $private = '<i class="fa-regular fa-lock" aria-hidden="true"></i> ';
                    }

                    return $icon . $private . $model->role;
                },
            ],
            'superior' => [
                'key' => 'parent_id',
                'label' => 'organisations.members.fields.parent',
                'render' => Standard::ENTITYLINK,
                'with' => 'superior',
            ],
            'locations' => [
                'label' => Module::plural(config('entities.ids.location'), 'entities.locations'),
                'class' => self::ONLY_DESKTOP,
                'render' => Standard::ENTITY_LOCATIONS,
                'with' => 'character.entity',
            ],
            'pinned' => [
                'label' => '<i class="fa-regular fa-map-pin" data-title="' . __('organisations.members.fields.pinned') . '" data-toggle="tooltip"></i>',
                'render' => function ($model) {
                    if (! $model->pinned()) {
                        return '';
                    }
                    if ($model->pinnedToCharacter()) {
                        return '<i class="fa-regular fa-user" data-toggle="tooltip" data-title="' . __('entities.character') . '"></i>';
                    } elseif ($model->pinnedToOrganisation()) {
                        return '<i class="fa-regular fa-screen-users" data-toggle="tooltip" data-title="' . __('entities.organisation') . '"></i>';
                    }

                    return '<i class="fa-regular fa-map-pin" data-toggle="tooltip" data-title="' . __('organisations.members.pinned.both') . '"></i>';
                },
            ],
        ];

        return $columns;
    }

    /**
     * Available actions on each row
     */
    public function actions(): array
    {
        return [
            self::ACTION_EDIT_DIALOG,
            self::ACTION_DELETE,
        ];
    }
}
