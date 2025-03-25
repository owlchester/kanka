<?php

namespace App\Renderers\Layouts\Timeline;

use App\Renderers\Layouts\Layout;

class Era extends Layout
{
    /**
     * Available column names
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
            'abbreviation' => [
                'key' => 'abbreviation',
                'label' => 'timelines/eras.fields.abbreviation',
            ],
            'position' => [
                'key' => 'position',
                'label' => 'maps/groups.fields.position',
            ],
            'start_year' => [
                'key' => 'start_year',
                'label' => 'timelines/eras.fields.start_year',
            ],
            'end_year' => [
                'key' => 'end_year',
                'label' => 'timelines/eras.fields.end_year',
            ],
            'is_collapsed' => [
                'key' => 'is_collapsed',
                'label' => 'timelines/eras.fields.is_collapsed',
                'render' => function ($model) {
                    if ($model->is_collapsed) {
                        return '<i class="fa-solid fa-check-circle" aria-hidden="true"></i>';
                    }

                    return '';
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
            self::ACTION_EDIT,
            self::ACTION_DELETE,
        ];
    }

    public function bulks(): array
    {
        return [
            self::ACTION_DELETE,
        ];
    }
}
