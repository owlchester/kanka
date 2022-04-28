<?php

namespace App\Renderers\Layouts\Character;

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
                'key' => 'name',
                'label' => 'organisations.fields.name',
                'render' => function ($model) {
                    return $model->organisation->tooltipedLink() . '<br />' . $model->organisation->type;
                },
            ],
            'role' => [
                'key' => 'role',
                'label' => 'organisations.members.fields.role',
                'render' => function ($model) {

                    $icon = '';
                    if ($model->inactive()) {
                        $icon = '<i class="fas fa-user-slash" title="' . __('organisations.members.status.inactive') . '" data-toggle="tooltip"></i>';
                    } elseif ($model->unknown()) {
                        $icon = '<i class="fas fa-question" title="' . __('organisations.members.status.unknown') . '" data-toggle="tooltip"></i>';
                    }

                    return $icon . $model->role;
                }
            ],
            'location' => [
                'key' => 'location.name',
                'label' => 'organisations.fields.location',
                'render' => function ($model) {
                    if (!$model->location) {
                        return null;
                    }
                    return $model->location->tooltipedLink();
                },
            ],
            'pinned' => [
                'label' => '<i class="fas fa-star" title="' . __('organisations.members.fields.pinned') . '" data-toggle="tooltip"></i>',
                'render' => function ($model) {
                    if (!$model->pinned()) {
                        return '';
                    }
                    if ($model->pinnedToCharacter())
                        return '<i class="fa-solid fa-user" data-toggle="tooltip" title="' . __('organisations.members.pinned.character') . '"></i>';
                    elseif ($model->pinnedToOrganisation())
                        return '<i class="ra ra-hood" data-toggle="tooltip" title="' . __('organisations.members.pinned.organisation') . '"></i>';
                    return '<i class="fas fa-star" data-toggle="tooltip" title="' . __('organisations.members.pinned.both') . '"></i>';
                }
            ]
        ];

        return $columns;
    }

    /**
     * Available actions on each row
     * @return array
     */
    public function actions(): array
    {
        return [
            self::ACTION_EDIT,
            self::ACTION_DELETE
        ];
    }
}
