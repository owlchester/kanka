<?php

namespace App\Observers;

use App\Enums\Visibility;
use App\Events\Maps\GroupChanged;
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

    public function deleted(MapGroup $mapGroup)
    {
        $mapGroup->map->touchSilently();
        $this->broadcastChange($mapGroup, 'deleted');
    }

    public function saved(MapGroup $mapGroup)
    {
        $this->reorder($mapGroup);
        $mapGroup->map->touchSilently();
        $this->broadcastChange($mapGroup, $mapGroup->wasRecentlyCreated ? 'created' : 'updated');
    }

    public function updated(MapGroup $mapGroup)
    {
        $this->broadcastChange($mapGroup, 'updated');
    }

    protected function broadcastChange(MapGroup $mapGroup, string $action): void
    {
        if (! in_array($mapGroup->visibility_id, [Visibility::All, Visibility::Member], true)) {
            return;
        }

        GroupChanged::dispatch($mapGroup, $action);
    }
}
