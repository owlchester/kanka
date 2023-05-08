<?php

namespace App\Observers;

use App\Models\Location;
use App\Models\MiscModel;

class LocationObserver extends MiscObserver
{
    /**
     * @param Location $location
     */
    public function deleting(Location $location)
    {
        /**
         * We need to do this ourselves and not let mysql to it (set null), because the nested wants to delete
         * all descendants when deleting the parent (soft delete)
         */
        foreach ($location->locations as $sub) {
            $sub->parent_location_id = null;
            $sub->saveQuietly();
        }

        $this->cleanupTree($location, 'parent_location_id');
    }

    /**
     * Delete the map when the entity is deleted
     * @param MiscModel|Location $model
     */
    public function deleted(MiscModel $model)
    {
        parent::deleted($model);

        /** @var Location $model */
        if ($model->trashed()) {
            return;
        }
    }
}
