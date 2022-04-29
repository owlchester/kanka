<?php

namespace App\Renderers\Layouts\Quest;

use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Quest extends Layout
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
                'label' => 'entities.quest',
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'quests.fields.type',
            ],
            'date' => [
                'key' => 'date',
                'label' => 'quests.fields.date',
                'render' => Standard::DATE,
            ],
            'completed' => [
                'key' => 'is_complete',
                'label' => 'quests.fields.is_completed',
                'render' => function ($model) {
                    if (!$model->is_completed) {
                        return '';
                    }
                    return '<i class="fa fa-check-circle" title="' . __('quests.fields.is_completed') . '"></i>';
                },

            ],
        ];

        return $columns;
    }
}
