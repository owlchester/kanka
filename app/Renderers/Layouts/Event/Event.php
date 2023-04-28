<?php

namespace App\Renderers\Layouts\Event;

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
            'event' => [
                'key' => 'event.name',
                'label' => 'crud.fields.parent',
                'render' => function ($model) {
                    if (!$model->event) {
                        return null;
                    }
                    return $model->event->tooltipedLink();
                },
                'visible' => function() {
                    return !request()->has('parent_id');
                }
            ],
        ];

        return $columns;
    }
}
