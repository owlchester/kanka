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
                'label' => Module::singular(config('entities.ids.quest'), 'entities.quest'),
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'crud.fields.type',
                'render' => function (\App\Models\Quest $model) {
                    return $model->entity->type;
                },
            ],
            'date' => [
                'key' => 'date',
                'label' => 'quests.fields.date',
                'render' => Standard::DATE,
            ],
            'completed' => [
                'key' => 'is_completed',
                'label' => 'quests.fields.is_completed',
                'render' => function ($model) {
                    if (! $model->is_completed) {
                        return '';
                    }

                    return '<i class="fa-solid fa-check-circle" data-title="' . __('quests.fields.is_completed') . '" aria-hidden="true"></i>';
                },
            ],
            'tags' => [
                'render' => Standard::TAGS,
            ],
        ];

        return $columns;
    }
}
