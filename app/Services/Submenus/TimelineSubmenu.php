<?php

namespace App\Services\Submenus;

use App\Models\Timeline;

class TimelineSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        /** @var Timeline $model */
        $model = $this->entity->child;
        $items['second']['timelines'] = [
            'name' => $this->entity->entityType->plural(),
            'route' => 'timelines.timelines',
            'count' => $model->descendants()->has('entity')->count(),
        ];
        if (isset($this->user) && $this->user->can('update', $this->entity)) {
            $items['second']['eras'] = [
                'name' => __('timelines.fields.eras'),
                'route' => 'timelines.timeline_eras.index',
                'count' => $model->eras->count(),
            ];
            $items['second']['reorder'] = [
                'name' => __('crud.actions.reorder'),
                'route' => 'timelines.reorder',
            ];
        }

        return $items;
    }
}
