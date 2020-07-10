<?php

namespace App\Observers;

use App\Models\Map;
use App\Models\MiscModel;
use Illuminate\Support\Facades\Storage;

class MapObserver extends MiscObserver
{
    /**
     * @param Map $map
     */
    public function saving(MiscModel $map)
    {
        // When saving a map that has an image but no height, force the height and width attribute to null
        // to be handled in the ImageHandler. It uses getAttributes on the model but these aren't present
        // for some reason.
        if (empty($map->height)) {
            $map->height = 0;
            $map->width = 0;
        }
        parent::saving($map);

        $map->grid = (int) $map->grid;
    }

    /**
     * @param Map $model
     */
    public function deleting(MiscModel $model)
    {
        /**
         * We need to do this ourselves and not let mysql to it (set null), because the plugin wants to delete
         * all descendants when deleting the parent, which is stupid.
         * @var Map $sub
         */
        foreach ($model->maps as $sub) {
            $sub->map_id = null;
            $sub->save();
        }

        // We need to refresh our foreign relations to avoid deleting our children nodes again
        $model->refresh();
    }
}
