<?php

namespace App\Renderers\Layouts\Location;

use App\Facades\Module;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Character extends Layout
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
            'character_id' => [
                'key' => 'name',
                'label' => Module::singular(config('entities.ids.character'), __('entities.character')),
                'render' => Standard::CHARACTER,
            ],
            'type' => [
                'key' => 'type',
                'label' => __('crud.fields.type'),
                'render' => function (\App\Models\Character $model) {
                    return $model->entity->type;
                },
            ],
            'locations' => [
                'key' => 'locations.name',
                'label' => Module::plural(config('entities.ids.location'), __('entities.locations')),
                'render' => Standard::ENTITY_LOCATIONS,
                'visible' => function () {
                    return ! request()->has('location_id');
                },
            ],
            'families' => [
                'label' => Module::plural(config('entities.ids.family'), __('entities.families')),
                'render' => Standard::ENTITYLIST,
                'with' => ['characterFamilies', 'family'],
            ],
            'races' => [
                'label' => Module::plural(config('entities.ids.race'), __('entities.races')),
                'class' => self::ONLY_DESKTOP,
                'render' => Standard::ENTITYLIST,
                'with' => ['characterRaces', 'race'],
            ],
            'tags' => [
                'render' => Standard::TAGS,
            ],
        ];

        return $columns;
    }
}
