<?php


namespace App\Observers;


use App\Facades\Identity;
use App\Models\Entity;
use App\Models\EntityLog;
use Carbon\Carbon;

class EntityLogObserver
{
    /**
     * @param Entity $entity
     */
    public function created(Entity $entity)
    {
        $log = new EntityLog();
        $log->entity_id = $entity->id;
        $log->created_by = auth()->user()->id;
        $log->impersonated_by = Identity::getImpersonatorId();
        $log->action = EntityLog::ACTION_CREATE;
        $log->save();

        $entity->is_created_now = true;
    }

    /**
     * @param Entity $entity
     */
    public function updated(Entity $entity)
    {
        // Don't log updates if just did one (typically when creating or restoring)
        if ($entity->updated_at == $entity->created_at || !empty($entity->getOriginal('deleted_at'))) {
            return;
        }
        //dd('not same');

        $log = new EntityLog();
        $log->entity_id = $entity->id;
        $log->created_by = auth()->user()->id;
        $log->impersonated_by = Identity::getImpersonatorId();
        $log->action = EntityLog::ACTION_UPDATE;
        $log->save();
    }

    /**
     * @param Entity $entity
     */
    public function deleted(Entity $entity)
    {
        // Not soft deleting? Nothing more to do
        if (!$entity->trashed()) {
            return;
        }

        $log = new EntityLog();
        $log->entity_id = $entity->id;
        $log->created_by = auth()->user()->id;
        $log->impersonated_by = Identity::getImpersonatorId();
        $log->action = EntityLog::ACTION_DELETE;
        $log->save();
    }


    /**
     * @param Entity $entity
     */
    public function restored(Entity $entity)
    {
        $log = new EntityLog();
        $log->entity_id = $entity->id;
        $log->created_by = auth()->user()->id;
        $log->impersonated_by = Identity::getImpersonatorId();
        $log->action = EntityLog::ACTION_RESTORE;
        $log->save();
    }
}
