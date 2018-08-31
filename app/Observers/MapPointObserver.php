<?php

namespace App\Observers;

use App\Models\MapPoint;
use App\Models\MiscModel;
use App\Services\ImageService;

class MapPointObserver
{
    /**
     * @param MapPoint $model
     */
    public function saving(MapPoint $model)
    {
        // Remove name if a target was provided
        if (!empty($model->target_id)) {
            $model->name = null;
        }
    }
}
