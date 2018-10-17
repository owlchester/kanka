<?php

namespace App\Observers;

use App\Models\Location;
use App\Models\MiscModel;
use App\Services\ImageService;

class LocationObserver extends MiscObserver
{
    /**
     * @param MiscModel $model
     */
    public function saving(MiscModel $model)
    {
        parent::saving($model);

        // Handle image. Let's use a service for this.
        ImageService::handle($model, $model->getTable(), 60, 'map');
    }


    /**
     * After saving the location, let's check if the parent location_id was removed.
     * If so, we need to make this location a "root" to clear up the previous
     * tree. We also need to stop this from looping ad infinitum.
     * @param MiscModel $model
     */
    public function saved(MiscModel $model)
    {
        parent::saved($model);

        if ($model->isDirty('location_id') && empty($model->location_id)) {
            if (!defined('MISCELLANY_REBUILDING_TREE')) {
                define('MISCELLANY_REBUILDING_TREE', true);
                $model->makeRoot()->save();
            }
        }
    }

    /**
     * @param Location $location
     */
    public function deleting(MiscModel $location)
    {
        parent::deleting($location);

        /**
         * We need to do this ourselves and not let mysql to it (set null), because the plugin wants to delete
         * all descendants when deleting the parent, which is stupid.
         */
        foreach ($location->locations as $sub) {
            $sub->parent_location_id = null;
            $sub->save();
        }

        // We need to refresh our foreign relations to avoid deleting our children nodes again
        $location->refresh();

        ImageService::cleanup($location, 'map');
    }
}
