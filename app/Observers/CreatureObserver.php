<?php

namespace App\Observers;

use App\Models\MiscModel;
use App\Models\Creature;
use App\Models\Location;

class CreatureObserver extends MiscObserver
{
    /**
     * @param MiscModel|Creature $model
     */
    public function crudSaved(MiscModel $model)
    {
        parent::crudSaved($model);
        /** @var Creature $creature */
        $creature = $model;
        $this->saveLocations($creature);
    }

    /**
     * @param Creature $creature
     */
    protected function saveLocations(Creature $creature): self
    {
        if (!request()->has('save_locations') && !request()->has('locations')) {
            return $this;
        }

        $existing = [];
        $unique = [];
        $recreate = [];
        foreach ($creature->locations as $location) {
            // If it already exists, we have an issue
            if (!empty($existing[$location->id])) {
                $recreate[$location->id] = $location->id;
                $creature->locations()->detach($location->id);
                continue;
            }
            $existing[$location->id] = $location->id;
            $unique[$location->id] = $location->id;
        }

        if (!empty($recreate)) {
            $creature->locations()->attach($recreate);
        }

        $locations = request()->get('locations', []);
        $newLocations = [];
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
            $newLocations[] = $location->id;
        }
        $creature->locations()->attach($newLocations);

        // Detach the remaining
        if (!empty($existing)) {
            $creature->locations()->detach($existing);
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
     * @param Creature $creature
     */
    public function deleting(Creature $creature)
    {
        /**
         * We need to do this ourselves and not let mysql to it (set null), because the plugin wants to delete
         * all descendants when deleting the parent, which is stupid.
         */
        foreach ($creature->creatures as $sub) {
            $sub->creature_id = null;
            $sub->saveQuietly();
        }

        $this->cleanupTree($creature, 'creature_id');
    }
}
