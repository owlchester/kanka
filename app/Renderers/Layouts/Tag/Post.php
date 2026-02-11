<?php

namespace App\Renderers\Layouts\Tag;

use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Post extends Layout
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
            'entity' => [
                'key' => 'entity.name',
                'label' => 'fields.entry.label',
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type_id',
                'label' => 'campaigns/categories.tab',
                'render' => function ($model) {
                    return $model->entity->entityType->name();
                },
            ],
            'tags' => [
                'render' => Standard::TAGS,
            ],

        ];

        return $columns;
    }
}
