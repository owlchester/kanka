<?php

namespace App\Observers;

use App\Events\Campaigns\EntityTypes\EntityTypeCreated;
use App\Events\Campaigns\EntityTypes\EntityTypeDeleted;
use App\Events\Campaigns\EntityTypes\EntityTypeUpdated;
use App\Models\EntityType;

class EntityTypeObserver
{
    public function created(EntityType $entityType)
    {
        EntityTypeCreated::dispatch($entityType, auth()->user());
    }

    public function updated(EntityType $entityType)
    {
        EntityTypeUpdated::dispatch($entityType, auth()->user());
    }

    public function deleted(EntityType $entityType)
    {
        EntityTypeDeleted::dispatch($entityType, auth()->user());
    }
}
