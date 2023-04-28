<?php

namespace App\Renderers\Layouts\Tag;

use App\Facades\Module;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Entity extends Layout
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
                'label' => 'crud.fields.entity',
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type_id',
                'label' => 'crud.fields.entity_type',
                'render' => function ($model) {
                    $singular = Module::singular($model->typeId());
                    if (!empty($singular)) {
                        return $singular;
                    }
                    return __('entities.' . $model->pluralType());
                }
            ],

        ];

        return $columns;
    }
}
