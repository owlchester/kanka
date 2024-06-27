<?php

namespace App\Renderers\Layouts\Race;

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
                'render' => Standard::IMAGE,
                'with' => ['target' => 'character']
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
                    return $model->character->type;
                },
            ],
            'location' => [
                'key' => 'location.name',
                'label' => Module::singular(config('entities.ids.location'), 'entities.location'),
                'render' => Standard::LOCATION,
            ],
            'races' => [
                'label' => Module::plural(config('entities.ids.race'), 'entities.races'),
                'class' => self::ONLY_DESKTOP,
                'render' => function ($model) {
                    $html = '<div class="flex flex-wrap gap-1">';
                    foreach ($model->character->races as $rel) {
                        $html .= '<a class="name"
                        data-toggle="tooltip-ajax"
                        data-id="' . $rel->entity->id . '"
                        data-url="' . route('entities.tooltip', [$rel->entity->campaign_id, $rel->entity->id]) . '"
                        href="' . $rel->entity->url() . '">' . $rel->name . '</a>';
                    }
                    $html .= '</div>';
                    return $html;
                },
                'visible' => function () {
                    return !request()->has('race_id');
                }
            ],
            'tags' => [
                'render' => Standard::TAGS
            ]
        ];

        return $columns;
    }
}
