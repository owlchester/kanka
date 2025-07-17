<?php

namespace App\Renderers\Layouts\Note;

use App\Facades\Module;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Note extends Layout
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
                'label' => Module::singular(config('entities.ids.note'), 'entities.note'),
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'crud.fields.type',
                'render' => function (\App\Models\Note $model) {
                    return $model->entity->type;
                },
            ],
            'tags' => [
                'render' => Standard::TAGS,
            ],
        ];

        return $columns;
    }
}
