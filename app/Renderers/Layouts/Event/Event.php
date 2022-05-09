<?php

namespace App\Renderers\Layouts\Event;

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
                'label' => 'entities.event',
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'events.fields.type',
            ],
            'date' => [
                'key' => 'date',
                'label' => 'events.fields.date',
            ],
            'event' => [
                'key' => 'event.name',
                'label' => 'events.fields.event',
                'render' => function ($model) {
                    if (!$model->event) {
                        return null;
                    }
                    return $model->event->tooltipedLink();
                },
            ],
        ];

        return $columns;
    }
}
