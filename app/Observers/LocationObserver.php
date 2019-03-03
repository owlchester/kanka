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

        // Skipping observer (for example when BULK or COPY)
        if ($model->savingObserver === true) {
            return;
        }

        // Handle map. Let's use a service for this.
        ImageService::handle($model, $model->getTable(), false, 'map');

        // Removed parent_location_id id
        if ($model->isDirty('parent_location_id') && empty($model->parent_location_id)) {
            $model->rebuildTree = true;
        }
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

        // After the modal has been saved, we might want to rebuild the tree.
        // Sadly, ->isDirty doesn't work here, as the model is refreshed at the end of the saving event.
        if ($model->rebuildTree) {
            $this->rebuildTree($model);
        }
    }

    /**
     * @param Location $location
     */
    private function rebuildTree(Location $location)
    {
        if (!defined('MISCELLANY_REBUILDING_TREE')) {
            define('MISCELLANY_REBUILDING_TREE', true);
            $location->makeRoot()->save();
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
