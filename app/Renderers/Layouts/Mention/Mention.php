<?php

namespace App\Renderers\Layouts\Mention;

use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Mention extends Layout
{
    /**
     * Available columns
     * @return array[]
     */
    public function columns(): array
    {
        $columns = [
            'name' => [
                'key' => 'name',
                'label' => 'entities/mentions.fields.element',
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'crud.fields.type',
                'render' => function ($model) {
                    if ($model->isEntity()) {
                        return __('entities.' . $model->entity->type());
                    } elseif ($model->isCampaign()){
                        return __('entities.campaign');
                    } elseif ($model->isTimelineElement()){
                        return __('entities.timeline_element');
                    } elseif ($model->isQuestElement()){
                        return __('entities.quest_element');
                    } elseif ($model->isPost()){
                        return __('entities.post');
                    }
                },
            ],
        ];

        return $columns;
    }
}
