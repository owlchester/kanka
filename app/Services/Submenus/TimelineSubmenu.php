<?php

namespace App\Services\Submenus;

use App\Facades\Module;

class TimelineSubmenu extends BaseSubmenu implements EntitySubmenu
{
    public function extra(): array
    {
        $items = [];
        $items['second']['timelines'] = [
            'name' => Module::plural($this->model->entityTypeId(), 'entities.timelines'),
            'route' => 'timelines.timelines',
            'count' => $this->model->descendants()->count()
        ];
        if (auth()->check() && auth()->user()->can('update', $this->model)) {
            $items['second']['eras'] = [
                'name' => 'timelines.fields.eras',
                'route' => 'timelines.timeline_eras.index',
                'count' => $this->model->eras->count()
            ];
            $items['second']['reorder'] = [
                'name' => 'timelines.show.tabs.reorder',
                'route' => 'timelines.reorder',
            ];
        }
        return $items;
    }
}
