<?php

namespace App\Services\Submenus;

use App\Facades\Module;
use App\Models\Timeline;

class TimelineSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        /** @var Timeline $model */
        $model = $this->entity->child;
        $items['second']['timelines'] = [
            'name' => Module::plural($model->entityTypeId(), 'entities.timelines'),
            'route' => 'timelines.timelines',
            'count' => $model->descendants()->has('entity')->count(),
        ];
        if (auth()->check() && auth()->user()->can('update', $this->entity)) {
            $items['second']['eras'] = [
                'name' => 'timelines.fields.eras',
                'route' => 'timelines.timeline_eras.index',
                'count' => $model->eras->count(),
            ];
            $items['second']['reorder'] = [
                'name' => 'crud.actions.reorder',
                'route' => 'timelines.reorder',
            ];
        }

        return $items;
    }
}
