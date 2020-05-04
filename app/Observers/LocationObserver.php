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
        if ($model->savingObserver === false) {
            return;
        }

        // Handle map. Let's use a service for this.
        ImageService::handle($model, $model->getTable(), false, 'map');
    }

    /**
     * @param Location $location
     */
    public function deleting(MiscModel $location)
    {
        /**
         * We need to do this ourselves and not let mysql to it (set null), because the nested wants to delete
         * all descendants when deleting the parent (soft delete)
         */
        foreach ($location->locations as $sub) {
            $sub->parent_location_id = null;
            $sub->save();
        }

        // We need to refresh our foreign relations to avoid deleting our children nodes again
        $location->refresh();
    }

    /**
     * Delete the map when the entity is deleted
     * @param MiscModel $model
     */
    public function deleted(MiscModel $model)
    {
        parent::deleted($model);

        if ($model->trashed()) {
            return;
        }

        ImageService::cleanup($model, 'map');
    }
}
