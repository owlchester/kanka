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
                'render' => function ($model) {
                    $private = null;

                    if (($model->entity && !$model->entity->is_private) ||
                        ($model->isQuestElement() && $model->questElement && $model->questElement->quest && $model->questElement->quest->entity && !$model->questElement->quest->entity->is_private) ||
                        ($model->isTimelineElement() && $model->timelineElement && $model->timelineElement->timeline && $model->timelineElement->timeline->entity && !$model->timelineElement->timeline->entity->is_private) ||
                        ($model->isPost() && $model->post && $model->post->entity && !$model->post->entity->is_private)) {
                            $private = '<i class="fa-solid fa-lock mr-1" title="' . __('crud.is_private') . '" data-toggle="tooltip" aria-hidden="true"></i>';
                    }
                    return $private . $model->mentionLink();
                },
            ],
            'type' => [
                'key' => 'type',
                'label' => 'crud.fields.type',
                'render' => function ($model) {
                    if ($model->entity) {
                        return __('entities.' . $model->entity->type());
                    } elseif ($model->isCampaign()){
                        return __('entities.campaign');
                    } elseif ($model->isTimelineElement()){
                        return __('entities.timeline_element');
                    } elseif ($model->isQuestElement()){
                        return __('entities.quest_element');
                    } elseif ($model->isPost()){
                        return __('entities.post');
                    } else {
                        return __('crud.hidden');
                    }
                },
            ],
        ];

        return $columns;
    }
}
