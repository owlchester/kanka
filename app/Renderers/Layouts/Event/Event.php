<?php

namespace App\Renderers\Layouts\Event;

use App\Facades\Module;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Event extends Layout
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
            'name' => [
                'key' => 'name',
                'label' => Module::singular(config('entities.ids.event'), __('entities.event')),
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => __('crud.fields.type'),
                'render' => function (\App\Models\Event $model) {
                    return $model->entity->type;
                },
            ],
            'date' => [
                'key' => 'date',
                'label' => __('events.fields.date'),
            ],
            'event' => [
                'key' => 'parent.name',
                'label' => __('crud.fields.parent'),
                'render' => Standard::ParentLink,
                'visible' => function () {
                    return ! request()->has('parent_id');
                },
            ],
            'tags' => [
                'render' => Standard::TAGS,
            ],
        ];

        return $columns;
    }
}
