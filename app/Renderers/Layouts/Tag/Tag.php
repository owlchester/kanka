<?php

namespace App\Renderers\Layouts\Tag;

use App\Facades\Module;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;
use Illuminate\Support\Facades\Blade;

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
            ],
            'colour' => [
                'key' => 'colour',
                'label' => 'crud.fields.colour',
                'render' => function ($tag) {
                    return Blade::render('<x-tags.bubble :tag="$tag" />', ['tag' => $tag]);
                },
            ],
            'tag' => [
                'key' => 'tag.name',
                'label' => 'crud.fields.parent',
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
