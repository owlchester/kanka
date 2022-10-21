<?php

namespace App\Renderers\Layouts\Creature;

use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Creature extends Layout
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
            'creature_id' => [
                'key' => 'name',
                'label' => 'entities.creature',
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'crud.fields.type',
            ],
            'creature' => [
                'key' => 'creature.name',
                'label' => 'creatures.fields.creature',
                'render' => function ($model) {
                    return $model->creature?->tooltipedLink();
                },
            ],
        ];

        return $columns;
    }
}
