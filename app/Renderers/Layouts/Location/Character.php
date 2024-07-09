<?php

namespace App\Renderers\Layouts\Location;

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
                'render' => function ($model) {
                    return $model->type;
                },
            ],
            'families' => [
                'label' => Module::plural(config('entities.ids.family'), 'entities.families'),
                'render' => function ($model) {
                    $families = [];
                    foreach ($model->characterFamilies as $family) {
                        if (!$family->family || !$family->family->entity) {
                            continue;
                        }
                        $families[] = $this->entityLink($family->family);
                    }
                    return implode(', ', $families);
                },
            ],
            'location' => [
                'key' => 'location.name',
                'label' => Module::singular(config('entities.ids.location'), 'entities.location'),
                'render' => Standard::LOCATION,
                'visible' => function () {
                    return !request()->has('location_id');
                }
            ],
            'races' => [
                'label' => Module::plural(config('entities.ids.race'), 'entities.races'),
                'class' => self::ONLY_DESKTOP,
                'render' => function ($model) {
                    $races = [];
                    foreach ($model->characterRaces as $race) {
                        if (!$race->race || !$race->race->entity) {
                            continue;
                        }
                        $races[] = $this->entityLink($race->race);
                    }
                    return implode(', ', $races);
                },
            ],
            'tags' => [
                'render' => Standard::TAGS
            ]
        ];

        return $columns;
    }
}
