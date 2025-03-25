<?php

namespace App\Renderers\Layouts\Map;

use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Layer extends Layout
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
            ],
            'name' => [
                'key' => 'name',
                'label' => 'crud.fields.name',
                'render' => function ($model) {
                    return '<a href="' . $model->getLink() . '">' . $model->name . '</a>';
                },
            ],
            'position' => [
                'key' => 'position',
                'label' => 'maps/layers.fields.position',
            ],
            'type' => [
                'label' => 'maps/layers.fields.type',
                'render' => function ($model) {
                    return __('maps/layers.short_types.' . $model->typeName());
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
            self::ACTION_EDIT,
            self::ACTION_DELETE,
        ];
    }

    public function bulks(): array
    {
        return [
            self::ACTION_EDIT,
            self::ACTION_DELETE,
        ];
    }
}
