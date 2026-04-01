<?php

namespace App\Renderers\Layouts\Map;

use App\Facades\Module;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Map extends Layout
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
                'label' => Module::singular(config('entities.ids.map'), __('entities.map')),
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => __('crud.fields.type'),
                'render' => function (\App\Models\Map $model) {
                    return $model->entity->type;
                },
            ],
            'map' => [
                'key' => 'parent.name',
                'label' => __('crud.fields.parent'),
                'render' => Standard::ParentLink,
                'visible' => function () {
                    return ! request()->has('map_id');
                },
            ],
            'tags' => [
                'render' => Standard::TAGS,
            ],
        ];

        return $columns;
    }
}
