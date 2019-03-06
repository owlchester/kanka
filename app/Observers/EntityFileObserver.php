<?php

namespace App\Observers;

use App\Models\EntityFile;
use App\Services\ImageService;

class EntityFileObserver
{
    /**
     * @param EntityFile $EntityFile
     */
    public function creating(EntityFile $entityFile)
    {
        $entityFile->created_by = auth()->user()->id;
    }

    /**
     * @param EntityFile $entityFile
     */
    public function saved(EntityFile $entityFile)
    {
        // When adding or changing an entity note to an entity, we want to update the
        // last updated date to reflect changes in the dashboard.
        $entityFile->entity->child->savingObserver = false;
        $entityFile->entity->child->touch();
    }

    /**
     * @param EntityFile $entityFile
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
