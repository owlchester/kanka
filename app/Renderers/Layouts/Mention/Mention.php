<?php

namespace App\Renderers\Layouts\Mention;

use App\Models\EntityMention;
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
                'render' => Standard::MENTION_LINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'crud.fields.type',
                'render' => function (EntityMention $model) {
                    if ($model->isCampaign()) {
                        return __('entities.campaign');
                    }
                    $base = __('crud.hidden');
                    if ($model->entity) {
                        $base = $model->entity->entityType->name();
                    }

                    if ($model->isTimelineElement()) {
                        return $base . ' (' . __('entities.timeline_element') . ')';
                    } elseif ($model->isQuestElement()) {
                        return $base . ' (' . __('entities.quest_element') . ')';
                    } elseif ($model->isPost()) {
                        return $base . ' (' . __('entities.post') . ')';
                    }
                    return $base;
                },
            ],
        ];

        return $columns;
    }
}
