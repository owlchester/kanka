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
        // Want to be able to set target_id to null
        $attr = 'target_id';
        $model->setAttribute($attr, (request()->has($attr) ? request()->post($attr) : null));

        // Remove name if a target was provided
        if (!empty($model->target_id)) {
            $model->name = null;
        }

        //dd($model);
    }
}
