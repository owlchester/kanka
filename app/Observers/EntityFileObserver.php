<?php

namespace App\Observers;

use App\Models\EntityFile;
use App\Services\ImageService;

class EntityFileObserver
{
    use PurifiableTrait;

    /**
     */
    public function creating(EntityFile $entityFile)
    {
        $entityFile->created_by = auth()->user()->id;
    }

    /**
     */
    public function saving(EntityFile $entityFile)
    {
        $entityFile->name = $this->purify($entityFile->name);
    }

    /**
     */
    public function saved(EntityFile $entityFile)
    {
        // When adding or changing an entity note to an entity, we want to update the
        // last updated date to reflect changes in the dashboard.
        $entityFile->entity->child->touchQuietly();
    }

    /**
     */
    public function deleted(EntityFile $entityFile)
    {
        ImageService::cleanup($entityFile, 'path');

        // When deleting an entity note, we want to update the entity's last update
        // for the dashboard. Careful of this when deleting an entity, we could be
        // entering a non-ending loop.
        if ($entityFile->entity) {
            $entityFile->entity->child->touch();
        }
    }
}
