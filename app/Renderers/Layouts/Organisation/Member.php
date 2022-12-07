<?php

namespace App\Renderers\Layouts\Organisation;

use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Member extends Layout
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
                'with' => ['target' => 'character']
            ],
            'character' => [
                'key' => 'character.name',
                'label' => 'entities.character',
                'render' => Standard::CHARACTER,
            ],
            'role' => [
                'key' => 'role',
                'label' => 'organisations.members.fields.role',
                'render' => function ($model) {

                    $icon = '';
                    if ($model->inactive()) {
                        $icon = '<i class="fa-solid fa-user-slash mr-1" title="' . __('organisations.members.status.inactive') . '" data-toggle="tooltip"></i>';
                    } elseif ($model->unknown()) {
                        $icon = '<i class="fa-solid fa-question mr-1" title="' . __('organisations.members.status.unknown') . '" data-toggle="tooltip"></i>';
                    }
                    return $icon . $model->role;
                }
            ],
            'superior' => [
                'key' => 'parent_id',
                'label' => 'organisations.members.fields.parent',
                'render' => function ($model) {
                    if (empty($model->parent) || empty($model->parent->character)) {
                        return '';
                    }
                    return $model->parent->character->tooltipedLink();
                }
            ],
            'location' => [
                'label' => 'entities.location',
                'class' => self::ONLY_DESKTOP,
                'render' => function ($model) {
                    if (!$model->character->location) {
                        return null;
                    }
                    return $model->character->location->tooltipedLink();
                },
            ],
            'pinned' => [
                'label' => '<i class="fa-solid fa-star" title="' . __('organisations.members.fields.pinned') . '" data-toggle="tooltip"></i>',
                'render' => function ($model) {
                    if (!$model->pinned()) {
                        return '';
                    }
                    if ($model->pinnedToCharacter())
                        return '<i class="fa-solid fa-user" data-toggle="tooltip" title="' . __('organisations.members.pinned.character') . '"></i>';
                    elseif ($model->pinnedToOrganisation())
                        return '<i class="ra ra-hood" data-toggle="tooltip" title="' . __('organisations.members.pinned.organisation') . '"></i>';
                    return '<i class="fa-solid fa-star" data-toggle="tooltip" title="' . __('organisations.members.pinned.both') . '"></i>';
                }
            ],
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
            self::ACTION_EDIT_AJAX,
            self::ACTION_DELETE
        ];
    }
}
