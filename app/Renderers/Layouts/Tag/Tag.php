<?php

namespace App\Renderers\Layouts\Tag;

use App\Facades\Module;
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
                'label' => Module::singular(config('entities.ids.tag'), 'entities.tag'),
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'crud.fields.type',
                'render' => function (\App\Models\Tag $model) {
                    return $model->entity->type;
                },
            ],
            'colour' => [
                'key' => 'colour',
                'label' => 'crud.fields.colour',
                'render' => function (\App\Models\Tag $tag) {
                    if (empty($tag->colour)) {
                        return '';
                    }
                    return '<div class="rounded-full w-6 h-6 bg-base-200 ' . $tag->colourClass() . '"></div>';
                },
            ],
            'tag' => [
                'key' => 'parent.name',
                'label' => 'crud.fields.parent',
                'render' => Standard::ParentLink,
                'visible' => function () {
                    return !request()->has('tag_id');
                }
            ],
        ];

        return $columns;
    }
}
