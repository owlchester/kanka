<?php


namespace App\Observers;


use App\Facades\Mentions;
use App\Models\MapGroup;
use App\Services\ImageService;

class MapGroupObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     * @param MapGroup $mapGroup
     */
    public function saving(MapGroup $mapGroup)
    {
        if (!empty($mapGroup->position)) {
            $mapGroup->position = (int) $mapGroup->position;
        } else {
            $lastGroup = $mapGroup->map->groups()->orderByDesc('position')->first();
            if ($lastGroup) {
                $mapGroup->position = (int)$lastGroup->position + 1;
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
        $mapGroup->map->touch();
    }

}
