<?php

namespace App\Observers;

use App\Models\Ability;
use App\Models\MiscModel;

class AbilityObserver extends MiscObserver
{
    /**
     * @param Ability $model
     */
    public function deleting(MiscModel $model)
    {
        /**
         * We need to do this ourselves and not let mysql to it (set null), because the plugin wants to delete
         * all descendants when deleting the parent, which is stupid.
         * @var Ability $sub
         */
        foreach ($model->abilities as $sub) {
            $sub->ability_id = null;
            $sub->save();
        }

        // We need to refresh our foreign relations to avoid deleting our children nodes again
        $model->refresh();
    }
}
