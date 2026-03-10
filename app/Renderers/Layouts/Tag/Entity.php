<?php

namespace App\Renderers\Layouts\Tag;

use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Entity extends Layout
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
                'label' => 'fields.entry.label',
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'crud.fields.type',
            ],
            'module' => [
                'key' => 'type_id',
                'label' => 'campaigns/categories.tab',
                'render' => function ($model) {
                    return $model->entityType->name();
                },
            ],
            'tags' => [
                'render' => Standard::TAGS,
            ],

        ];

        return $columns;
    }
}
