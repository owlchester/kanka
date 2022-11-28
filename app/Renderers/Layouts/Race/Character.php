<?php

namespace App\Renderers\Layouts\Race;

use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Character extends Layout
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
            'character_id' => [
                'key' => 'name',
                'label' => 'entities.character',
                'render' => Standard::CHARACTER,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'crud.fields.type',
                'render' => function ($model) {
                    return $model->type;
                },
            ],
            'location' => [
                'key' => 'location.name',
                'label' => 'entities.location',
                'render' => function ($model) {
                    if (!$model->location) {
                        return null;
                    }
                    return $model->location->tooltipedLink();
                },
            ],
            'races' => [
                'label' => 'entities.races',
                'class' => self::ONLY_DESKTOP,
                'render' => function ($model) {
                    $models = [];
                    foreach ($model->races as $sub) {
                        $models[] = $sub->tooltipedLink();
                    }
                    return implode(', ', $models);
                },
                'visible' => function () {
                    return !request()->has('race_id');
                }
            ],
        ];

        return $columns;
    }
}
