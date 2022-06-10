<?php

namespace App\Renderers\Layouts\Race;

use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Race extends Layout
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
            'race_id' => [
                'key' => 'name',
                'label' => 'races.fields.name',
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'races.fields.type',
            ],
            'race' => [
                'key' => 'race.name',
                'label' => 'races.fields.race',
                'render' => function ($model) {
                    if (!$model->race) {
                        return null;
                    }
                    return $model->race->tooltipedLink();
                },
            ],
            'characters' => [
                'label' => 'races.fields.characters',
                'render' => function ($model) {
                    return $model->characters->count();
                }
            ],
        ];

        return $columns;
    }
}
