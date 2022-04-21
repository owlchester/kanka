<?php

namespace App\Renderers\Layouts\Location;

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
                'label' => 'characters.fields.name',
                'render' => Standard::CHARACTER,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'characters.fields.type',
                'render' => function ($model) {
                    return $model->type;
                },
            ],
            'families' => [
                'label' => 'characters.fields.families',
                'class' => self::ONLY_DESKTOP,
                'render' => function ($model) {
                    $models = [];
                    foreach ($model->families as $sub) {
                        $models[] = $sub->tooltipedLink();
                    }
                    return implode(', ', $models);
                }
            ],
            'location' => [
                'key' => 'location.name',
                'label' => 'characters.fields.location',
                'render' => function ($model) {
                    if (!$model->location) {
                        return null;
                    }
                    return $model->location->tooltipedLink();
                },
                'visible' => function () {
                    return !request()->has('location_id');
                }
            ],
            'races' => [
                'label' => 'characters.fields.races',
                'class' => self::ONLY_DESKTOP,
                'render' => function ($model) {
                    $models = [];
                    foreach ($model->races as $sub) {
                        $models[] = $sub->tooltipedLink();
                    }
                    return implode(', ', $models);
                }
            ],
        ];

        return $columns;
    }
}
