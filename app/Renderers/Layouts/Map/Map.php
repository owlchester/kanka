<?php

namespace App\Renderers\Layouts\Map;

use App\Facades\Module;
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
                'label' => Module::singular(config('entities.ids.map'), 'entities.map'),
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'crud.fields.type',
            ],
            'map' => [
                'key' => 'map.name',
                'label' => 'crud.fields.parent',
                'render' => function ($model) {
                    if (!$model->map) {
                        return null;
                    }
                    return $model->map->tooltipedLink();
                },
                'visible' => function () {
                    return !request()->has('map_id');
                }
            ],
        ];

        return $columns;
    }
}
