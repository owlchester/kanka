<?php

namespace App\Observers;

use App\Models\MiscModel;
use App\Models\Race;
use App\Models\Location;
use Illuminate\Support\Collection;

class RaceObserver extends MiscObserver
{
    /**
     * @param MiscModel $model
     */
    public function crudSaved(MiscModel $model)
    {
        parent::crudSaved($model);
        $this->saveLocations($model);
    }

    /**
     * @param MiscModel $race
     */
    protected function saveLocations(MiscModel $race): self
    {
        if (!request()->has('save_locations') && !request()->has('locations')) {
            return $this;
        }

        /** @var Location $locations */
        $existing = [];
        $unique = [];
        $recreate = [];
        foreach ($race->locations as $location) {
            // If it already exists, we have an issue
            if (!empty($existing[$location->id])) {
                $recreate[$location->id] = $location->id;
                $race->locations()->detach($location->id);
                continue;
            }
            $existing[$location->id] = $location->id;
            $unique[$location->id] = $location->id;
        }

        if (!empty($recreate)) {
            $race->locations()->attach($recreate);
        }

        $locations = request()->get('locations', []);
        $newFamilies = [];
        foreach ($locations as $id) {
            // Existing race, do nothing
            if (!empty($existing[$id])) {
                unset($existing[$id]);
                continue;
            }
            // If already managed, again, ignore
            if (!empty($unique[$id])) {
                continue;
            }

            $location = Location::find($id);
            if (empty($location)) {
                continue;
            }
            $newFamilies[] = $location->id;
        }
        $race->locations()->attach($newFamilies);

        // Detach the remaining
        if (!empty($existing)) {
            $race->locations()->detach($existing);
        }

        return $this;
    }

    /**
     * @param MiscModel $model
     */
    public function saved(MiscModel $model)
    {
        parent::saved($model);
    }

    /**
     * @param Race $race
     */
    public function deleting(MiscModel $race)
    {
        /**
         * We need to do this ourselves and not let mysql to it (set null), because the plugin wants to delete
         * all descendants when deleting the parent, which is stupid.
         * @var Race $sub
         */
        foreach ($race->races as $sub) {
            $sub->race_id = null;
            $sub->save();
        }

        $this->cleanupTree($race, 'race_id');
    }
}
