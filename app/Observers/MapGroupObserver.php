<?php

namespace App\Observers;

use App\Events\Maps\ContentsChanged;
use App\Models\Map;
use App\Models\MapGroup;

class MapGroupObserver
{
    use ReorderTrait;

    public function saving(MapGroup $mapGroup)
    {
        if (! empty($mapGroup->position)) {
            $mapGroup->position = (int) $mapGroup->position;
        } else {
            $lastGroup = $mapGroup->map->groups()->max('position');
            if ($lastGroup) {
                $mapGroup->position = (int) $lastGroup + 1;
            } else {
                $mapGroup->position = 1;
            }
        }
    }

    public function saved(MapGroup $mapGroup)
    {
        $mapGroup->map->touchSilently();
    }

    public function created(MapGroup $mapGroup): void
    {
        $this->reorder($mapGroup);
        $this->broadcastContents($mapGroup->map);
    }

    public function updated(MapGroup $mapGroup): void
    {
        if ($mapGroup->wasChanged('position')) {
            $this->reorder($mapGroup);
        }
        $this->broadcastContents($mapGroup->map);
    }

    public function deleted(MapGroup $mapGroup)
    {
        $mapGroup->map->touchSilently();
        $this->broadcastContents($mapGroup->map);
    }

    protected function broadcastContents(Map $map): void
    {
        ContentsChanged::dispatch($map);
        ContentsChanged::dispatch($map, true);
    }
}
