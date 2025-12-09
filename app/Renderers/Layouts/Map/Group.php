<?php

namespace App\Renderers\Layouts\Map;

use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Group extends Layout
{
    /**
     * Available columnsname
     *
     * @return array[]
     */
    public function columns(): array
    {
        $columns = [
            'name' => [
                'key' => 'name',
                'label' => 'crud.fields.name',
                'render' => function ($model) {
                    return '<a href="' . $model->getLink() . '" data-target="primary-dialog" data-url="' . $model->getLink() . '" data-toggle="dialog" class="text-link">' . $model->name . '</a>';
                },
            ],
            'position' => [
                'key' => 'position',
                'label' => 'maps/groups.fields.position',
            ],
            'shown' => [
                'label' => 'maps/groups.fields.is_shown',
                'render' => function ($model) {
                    if ($model->is_shown) {
                        return '<i class="fa-regular fa-check" aria-hidden="true"></i>';
                    }

                    return '';
                },
            ],
            'parent' => [
                'label' => 'maps/groups.fields.parent',
                'key' => 'parent_id',
                'render' => function ($model) {
                    if ($model->parent) {
                        return '<a href="' . $model->parent->getLink() . '" data-target="primary-dialog" data-url="' . $model->parent->getLink() . '" data-toggle="dialog" class="text-link">' . $model->parent->name . '</a>';
                    }

                    return '';
                },
            ],
            'visibility' => [
                'label' => 'crud.fields.visibility',
                'render' => Standard::VISIBILITY,
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

    public function bulks(): array
    {
        return [
            self::ACTION_EDIT_DIALOG,
            self::ACTION_DELETE,
        ];
    }
}
