<?php

namespace App\Renderers\Layouts\Family;

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
            'location' => [
                'key' => 'location.name',
                'label' => 'characters.fields.location',
                'render' => function ($model) {
                    if (!$model->location) {
                        return null;
                    }
                    return $model->location->tooltipedLink();
                },
            ],
            'families' => [
                'label' => 'characters.fields.families',
                'render' => function ($model) {
                    $models = [];
                    foreach ($model->families as $sub) {
                        $models[] = $sub->tooltipedLink();
                    }
                    return implode(', ', $models);
                },
                'visible' => function () {
                    return !request()->has('family_id');
                }
            ],
        ];

        return $columns;
    }
}
