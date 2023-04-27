<?php

namespace App\Renderers\Layouts\Ability;

use App\Facades\Module;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Ability extends Layout
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
                'label' => Module::singular(config('entities.ids.ability'), 'entities.ability'),
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'crud.fields.type',
            ],
            'ability' => [
                'key' => 'ability.name',
                'label' => 'crud.fields.parent',
                'render' => function ($model) {
                    if (!$model->ability) {
                        return null;
                    }
                    return $model->ability->tooltipedLink();
                },
            ],
        ];

        return $columns;
    }
}
