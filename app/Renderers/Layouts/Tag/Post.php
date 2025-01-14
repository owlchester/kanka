<?php

namespace App\Renderers\Layouts\Tag;

use App\Facades\Module;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Post extends Layout
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
            'entity' => [
                'key' => 'entity.name',
                'label' => 'crud.fields.entity',
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type_id',
                'label' => 'crud.fields.entity_type',
                'render' => function ($model) {
                    $singular = Module::singular($model->entity->typeId());
                    if (!empty($singular)) {
                        return $singular;
                    }
                    return __('entities.' . $model->entity->pluralType());
                }
            ],
            'tags' => [
                'render' => Standard::TAGS
            ]

        ];

        return $columns;
    }
}
