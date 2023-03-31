<?php

namespace App\Renderers\Layouts\Mention;

use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Mention extends Layout
{
    /**
     * Available columns
     * @return array[]
     */
    public function columns(): array
    {
        $columns = [
            'name' => [
                'key' => 'name',
                'label' => 'entities/mentions.fields.element',
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'crud.fields.type',
                'render' => function ($model) {
                    return __('entities.' . $model->entity->type());
                },
            ],
        ];

        return $columns;
    }
}
