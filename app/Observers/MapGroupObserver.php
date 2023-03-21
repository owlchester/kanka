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
     * @param MapGroup $mapGroup
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
     * @param MapGroup $mapGroup
     */
    public function deleted(MapGroup $mapGroup)
    {
        $mapGroup->map->touch();
    }

    /**
     * @param MapGroup $mapGroup
     */
    public function saved(MapGroup $mapGroup)
    {
        $this->reorder($mapGroup);
        $mapGroup->map->touch();
    }
}
