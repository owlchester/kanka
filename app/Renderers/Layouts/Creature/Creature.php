<?php

namespace App\Renderers\Layouts\Creature;

use App\Facades\Module;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Creature extends Layout
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
            'creature_id' => [
                'key' => 'name',
                'label' => Module::singular(config('entities.ids.creature'), 'entities.creature'),
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'crud.fields.type',
                'render' => function (\App\Models\Creature $model) {
                    return $model->entity->type;
                },
            ],
            'creature' => [
                'key' => 'parent.name',
                'label' => 'crud.fields.parent',
                'render' => Standard::ParentLink,
                'visible' => function () {
                    return !request()->has('parent_id');
                }
            ],
            'tags' => [
                'render' => Standard::TAGS
            ],
        ];

        return $columns;
    }
}
