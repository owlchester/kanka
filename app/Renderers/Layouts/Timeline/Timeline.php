<?php

namespace App\Renderers\Layouts\Timeline;

use App\Facades\Module;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Timeline extends Layout
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
                'label' => Module::singular(config('entities.ids.timeline'), 'entities.timeline'),
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'crud.fields.type',
            ],
            'timeline' => [
                'key' => 'parent.name',
                'label' => 'crud.fields.parent',
                'render' => function ($model) {
                    return $model->parent?->tooltipedLink();
                },
                'visible' => function () {
                    return !request()->has('parent_id');
                }
            ],
            'tags' => [
                'render' => Standard::TAGS
            ]
        ];

        return $columns;
    }
}
