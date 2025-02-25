<?php

namespace App\Renderers\Layouts\Family;

use App\Facades\Module;
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
                'label' => Module::singular(config('entities.ids.character'), 'entities.character'),
                'render' => Standard::CHARACTER,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'crud.fields.type',
                'render' => function (\App\Models\Character $model) {
                    return $model->entity->type;
                },
            ],
            'location' => [
                'label' => Module::singular(config('entities.ids.location'), 'entities.location'),
                'render' => Standard::LOCATION,
            ],
            'families' => [
                'label' => Module::plural(config('entities.ids.family'), 'entities.families'),
                'render' => Standard::ENTITYLIST,
                'with' => ['characterFamilies', 'family'],
                'visible' => function () {
                    return !request()->has('family_id');
                }
            ],
            'tags' => [
                'render' => Standard::TAGS
            ]
        ];

        return $columns;
    }
}
