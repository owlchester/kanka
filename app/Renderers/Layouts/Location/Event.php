<?php

namespace App\Renderers\Layouts\Location;

use App\Facades\Module;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Event extends Layout
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
            'name' => [
                'key' => 'name',
                'label' => Module::singular(config('entities.ids.event'), 'entities.event'),
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'crud.fields.type',
            ],
            'date' => [
                'key' => 'date',
                'label' => 'events.fields.date',
            ],
            'tags' => [
                'render' => Standard::TAGS
            ]
        ];

        return $columns;
    }
}
