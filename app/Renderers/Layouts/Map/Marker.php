<?php

namespace App\Renderers\Layouts\Map;

use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Marker extends Layout
{
    /**
     * Available columns
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
                    return $model->markerLink();
                },
            ],
            'entity_id' => [
                'label' => 'fields.description.label',
                'render' => Standard::ENTITYLINK,
            ],
            'groups' => [
                'label' => 'maps/markers.fields.group',
                'render' => function ($model) {
                    return $model->group?->name;
                },
            ],
            'type' => [
                'label' => 'crud.fields.type',
                'render' => function ($model) {
                    return $model->typeLabel();
                },
            ],
            'icon' => [
                'label' => 'maps/markers.fields.icon',
                'render' => function ($model) {
                    return $model->datagridMarkerIcon();
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
            self::ACTION_COPY,
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
