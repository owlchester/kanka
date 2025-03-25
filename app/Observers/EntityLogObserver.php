<?php

namespace App\Observers;

use App\Facades\EntityLogger;
use App\Models\Entity;

/**
 * Class EntityLogObserver
 *
 * Added as an observer to the Entity model
 */
class EntityLogObserver
{
    public function created(Entity $entity)
    {
        EntityLogger::entity($entity)->create();
    }

    public function updated(Entity $entity)
    {
        // Don't log updates if just did one (typically when creating, restoring or bulk editing)
        if (! empty($entity->getOriginal('deleted_at'))) {
            return;
        }

        EntityLogger::entity($entity)->update();
    }

    public function deleted(Entity $entity)
    {
        // Not soft deleting? Nothing more to do
        if (! $entity->trashed()) {
            return;
        }
        EntityLogger::entity($entity)->delete();
    }

    public function restored(Entity $entity)
    {
        EntityLogger::entity($entity)->restore();
    }
}
