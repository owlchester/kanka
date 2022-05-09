<?php

namespace App\Renderers\Layouts\Tag;

use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Tag extends Layout
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
                'label' => 'tags.fields.name',
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'tags.fields.type',
            ],
            'colour' => [
                'key' => 'colour',
                'label' => 'crud.fields.colour',
                'render' => 'bubble()',
            ],
            'tag' => [
                'key' => 'tag.name',
                'label' => 'tags.fields.tag',
                'render' => function ($model) {
                    if (!$model->tag) {
                        return null;
                    }
                    return $model->tag->tooltipedLink();
                },
                'visible' => function () {
                    return !request()->has('tag_id');
                }
            ],
        ];

        return $columns;
    }
}
