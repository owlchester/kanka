<?php

namespace App\Renderers\Layouts\Family;

use App\Facades\Module;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Family extends Layout
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
            'family_id' => [
                'key' => 'name',
                'label' => Module::singular(config('entities.ids.family'), 'entities.family'),
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'crud.fields.type',
            ],
            'location' => [
                'key' => 'location.name',
                'label' => Module::singular(config('entities.ids.location'), 'entities.location'),
                'render' => function ($model) {
                    if (!$model->location) {
                        return null;
                    }
                    return $model->location->tooltipedLink();
                },
            ],
            'family' => [
                'key' => 'family.name',
                'label' => 'crud.fields.parent',
                'render' => function ($model) {
                    if (!$model->family) {
                        return null;
                    }
                    return $model->family->tooltipedLink();
                },
                'visible' => function () {
                    return !request()->has('parent_id');
                }
            ],
        ];

        return $columns;
    }
}
