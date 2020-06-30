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
//    public function saving(MiscModel $map)
//    {
//        parent::saving($map);
//
//        if ($map->isDirty('image')) {
//            $path = Storage::get($map->image);
//            $sizes = getimagesize($path);
//            $map->width = $sizes[0];
//            $map->height = $sizes[1];
//        }
//    }

    /**
     * @param Map $model
     */
    public function deleting(MiscModel $model)
    {
        dd('0why deleting');
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
