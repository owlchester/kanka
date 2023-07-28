<?php

namespace App\Observers;

use App\Models\MiscModel;
use App\Models\Creature;
use App\Models\Location;
use App\Observers\Concerns\HasLocations;

class CreatureObserver extends MiscObserver
{
    use HasLocations;

    /**
     * @param Creature $creature
     */
    public function crudSaved(Creature $creature)
    {
        if (!request()->has('save_locations') && !request()->has('locations')) {
            return;
        }
        $this->saveLocations($creature);
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
