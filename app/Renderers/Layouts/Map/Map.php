<?php

namespace App\Renderers\Layouts\Map;

use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Map extends Layout
{
    /**
     * Available columns
     * @return array[]
     */
    public function columns(): array
    {
        $columns = [
            'image' => [
                'render' => Standard::IMAGE
            ],
            'name' => [
                'key' => 'name',
                'label' => 'entities.map',
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'maps.fields.type',
            ],
            'map' => [
                'key' => 'map.name',
                'label' => 'maps.fields.map',
                'render' => function ($model) {
                    if (!$model->map) {
                        return null;
                    }
                    return $model->map->tooltipedLink();
                },
            ],
        ];

        return $columns;
    }
}
