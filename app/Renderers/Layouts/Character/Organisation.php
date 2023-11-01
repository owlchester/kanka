<?php

namespace App\Renderers\Layouts\Character;

use App\Facades\Module;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Organisation extends Layout
{
    /**
     * Available columns
     * @return array[]
     */
    public function columns(): array
    {
        $columns = [
            'image' => [
                'render' => Standard::IMAGE,
                'with' => ['target' => 'organisation']
            ],
            'organisation' => [
                'key' => 'organisation.name',
                'label' => Module::singular(config('entities.ids.organisation'), 'entities.organisation'),
                'render' => function ($model) {
                    $defunctIcon = null;
                    if ($model->organisation->is_defunct) {
                        $defunctIcon = ' <i class="fa-solid fa-shop-slash" data-title="' . __('organisations.fields.is_defunct') . '" aria-hidden="true"></i>';
                    }
                    return $model->organisation->tooltipedLink() . $defunctIcon . '<br />' . $model->organisation->type;
                },
            ],
            'role' => [
                'key' => 'role',
                'label' => 'organisations.members.fields.role',
                'render' => function ($model) {
                    $icon = '';
                    if ($model->inactive()) {
                        $icon = '<i class="fa-solid fa-user-slash mr-1" data-title="' . __('organisations.members.status.inactive') . '" data-toggle="tooltip"></i>';
                    } elseif ($model->unknown()) {
                        $icon = '<i class="fa-solid fa-question mr-1" data-title="' . __('organisations.members.status.unknown') . '" data-toggle="tooltip"></i>';
                    }

                    return $icon . $model->role;
                }
            ],
            'location' => [
                'key' => 'location.name',
                'label' => Module::singular(config('entities.ids.location'), 'entities.location'),
                'render' => function ($model) {
                    if (!$model->organisation->location) {
                        return null;
                    }
                    return $model->organisation->location->tooltipedLink();
                },
            ],
            'pinned' => [
                'label' => '<i class="fa-solid fa-star" data-title="' . __('organisations.members.fields.pinned') . '" data-toggle="tooltip"></i>',
                'render' => function ($model) {
                    if (!$model->pinned()) {
                        return '';
                    }
                    if ($model->pinnedToCharacter()) {
                        return '<i class="fa-solid fa-user" data-toggle="tooltip" data-title="' . __('organisations.members.pinned.character') . '"></i>';
                    } elseif ($model->pinnedToOrganisation()) {
                        return '<i class="ra ra-hood" data-toggle="tooltip" data-title="' . __('organisations.members.pinned.organisation') . '"></i>';
                    }
                    return '<i class="fa-solid fa-star" data-toggle="tooltip" data-title="' . __('organisations.members.pinned.both') . '"></i>';
                }
            ],
            'tags' => [
                'render' => Standard::TAGS
            ]
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
            self::ACTION_DELETE
        ];
    }
}
