<?php

namespace App\Renderers\Layouts\Tag;

use App\Facades\Module;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Tag extends Layout
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
                'label' => Module::singular(config('entities.ids.tag'), __('entities.tag')),
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => __('crud.fields.type'),
                'render' => function (\App\Models\Tag $model) {
                    return $model->entity->type;
                },
            ],
            'colour' => [
                'key' => 'colour',
                'label' => __('crud.fields.colour'),
                'render' => function (\App\Models\Tag $tag) {
                    if (! $tag->hasColour()) {
                        return '';
                    }

                    return '<div class="rounded-full w-6 h-6" style="' . e($tag->colourStyle()) . '"></div>';
                },
            ],
            'tag' => [
                'key' => 'parent.name',
                'label' => __('crud.fields.parent'),
                'render' => Standard::ParentLink,
                'visible' => function () {
                    return ! request()->has('tag_id');
                },
            ],
        ];

        return $columns;
    }
}
