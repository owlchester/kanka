<?php

namespace App\Renderers\Layouts\Race;

use App\Facades\Module;
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
                'label' => Module::singular(config('entities.ids.race'), 'entities.race'),
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'crud.fields.type',
            ],
            'race' => [
                'key' => 'race.name',
                'label' => 'crud.fields.parent',
                'render' => function ($model) {
                    if (!$model->race) {
                        return null;
                    }
                    return $model->race->tooltipedLink();
                },
            ],
            'characters' => [
                'label' => Module::plural(config('entities.ids.character'), 'entities.characters'),
                'render' => function ($model) {
                    return $model->characters->count();
                }
            ],
        ];

        return $columns;
    }
}
