<?php

namespace App\Renderers\Layouts\Map;

use App\Models\MapGroup;
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
                'label' => __('crud.fields.name'),
                'render' => function (MapGroup $model) {
                    $link = route('maps.map_groups.edit', [$this->campaign, 'map' => $model->map_id, $model->id]);
                    return '<a href="' . $link . '" data-target="primary-dialog" data-url="' . $link . '" data-toggle="dialog" class="text-link">' . $model->name . '</a>';
                },
            ],
            'position' => [
                'key' => 'position',
                'label' => __('maps/groups.fields.position'),
            ],
            'shown' => [
                'label' => __('maps/groups.fields.is_shown'),
                'render' => function ($model) {
                    if ($model->is_shown) {
                        return '<i class="fa-regular fa-check" aria-hidden="true"></i>';
                    }

                    return '';
                },
            ],
            'parent' => [
                'label' => __('maps/groups.fields.parent'),
                'key' => 'parent_id',
                'render' => function (MapGroup $model) {
                    if ($model->parent) {
                        $link = route('maps.map_groups.edit', [$this->campaign, 'map' => $model->parent->map_id, $model->parent->id]);
                        return '<a href="' . $link . '" data-target="primary-dialog" data-url="' . $link . '" data-toggle="dialog" class="text-link">' . $model->parent->name . '</a>';
                    }

                    return '';
                },
            ],
            'visibility' => [
                'label' => __('crud.fields.visibility'),
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
