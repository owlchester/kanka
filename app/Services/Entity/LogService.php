<?php

namespace App\Services\Entity;

use App\Models\Entity;
use App\Models\EntityLog;

class LogService
{
    /**
     * Rather than create logs for old entities, we add a quick check on each
     * call and populate the table if the user actually wants to use this
     * information.
     * @param Entity $entity
     */
    public function createMissingLogs(Entity $entity)
    {
        return $entity;

        if ($entity->logs()->count() < 2) {
            if ($entity->logs()->action(EntityLog::ACTION_CREATE)->count() == 0) {
                $entityLog = new EntityLog();
                $entityLog->timestamps = false;
                $entityLog->entity_id = $entity->id;
                $entityLog->action = EntityLog::ACTION_CREATE;
                $entityLog->created_by = $entity->created_by;
                $entityLog->created_at = $entity->created_at;
                $entityLog->save();
            }

            if ($entity->logs()->action(EntityLog::ACTION_UPDATE)->count() == 0) {
                $entityLog = new EntityLog();
                $entityLog->timestamps = false;
                $entityLog->entity_id = $entity->id;
                $entityLog->action = EntityLog::ACTION_UPDATE;
                $entityLog->created_by = $entity->updated_by;
                $entityLog->created_at = $entity->updated_at;
                $entityLog->save();
            }
        }

        return $entity;
    }
}
