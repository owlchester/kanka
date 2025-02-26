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
                'render' => function (\App\Models\Family $model) {
                    return $model->entity->type;
                },
            ],
            'location' => [
                'key' => 'location.name',
                'label' => Module::singular(config('entities.ids.location'), 'entities.location'),
                'render' => Standard::LOCATION,
            ],
            'family' => [
                'key' => 'parent.name',
                'label' => 'crud.fields.parent',
                'render' => Standard::ParentLink,
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
