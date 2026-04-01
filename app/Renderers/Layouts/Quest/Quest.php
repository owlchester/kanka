<?php

namespace App\Renderers\Layouts\Quest;

use App\Facades\Module;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Quest extends Layout
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
                'label' => Module::singular(config('entities.ids.quest'), __('entities.quest')),
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => __('crud.fields.type'),
                'render' => function (\App\Models\Quest $model) {
                    return $model->entity->type;
                },
            ],
            'date' => [
                'key' => 'date',
                'label' => __('quests.fields.date'),
                'render' => Standard::DATE,
            ],
            'completed' => [
                'key' => 'status',
                'label' => __('quests.fields.status'),
                'render' => function (\App\Models\Quest $model) {
                    if ($model->isOngoing()) {
                        return '<i class="fa-regular fa-hourglass" data-title="' . __('quests.status.ongoing') . '" aria-hidden="true"></i>';
                    } elseif ($model->isCompleted()) {
                        return '<i class="fa-regular fa-check-circle" data-title="' . __('quests.status.completed') . '" aria-hidden="true"></i>';
                    } elseif ($model->isAbandoned()) {
                        return '<i class="fa-regular fa-ban" data-title="' . __('quests.status.abandoned') . '" aria-hidden="true"></i>';
                    }

                    return '';
                },
            ],
            'location' => [
                'key' => 'location.name',
                'label' => Module::singular(config('entities.ids.location'), __('entities.location')),
                'render' => Standard::LOCATION,
                'visible' => function () {
                    return ! request()->has('location_id');
                },
            ],
            'tags' => [
                'render' => Standard::TAGS,
            ],
        ];

        return $columns;
    }
}
