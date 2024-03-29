<?php

namespace App\Observers;

use App\Models\MapGroup;

class MapGroupObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;
    use ReorderTrait;

    /**
     */
    public function saving(MapGroup $mapGroup)
    {
        if (!empty($mapGroup->position)) {
            $mapGroup->position = (int) $mapGroup->position;
        } else {
            $lastGroup = $mapGroup->map->groups()->max('position');
            if ($lastGroup) {
                $mapGroup->position = (int)$lastGroup + 1;
            } else {
                $mapGroup->position = 1;
            }
        }
    }

    /**
     */
    public function deleted(MapGroup $mapGroup)
    {
        $mapGroup->map->touch();
    }

    /**
     */
    public function saved(MapGroup $mapGroup)
    {
        $this->reorder($mapGroup);
        $mapGroup->map->touchSilently();
    }
}
