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
                    return '<a href="' . $model->getLink() . '">' . $model->name . '</a>';
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
                        return '<i class="fa-solid fa-check"></i>';
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
