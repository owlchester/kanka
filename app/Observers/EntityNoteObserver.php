<?php

namespace App\Observers;

use App\Facades\Mentions;
use App\Models\EntityNote;
use App\Services\EntityMappingService;
use Illuminate\Support\Facades\Auth;

class EntityNoteObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     * Service used to build the map of the entity
     * @var EntityMappingService
     */
    protected $entityMappingService;

    /**
     * CharacterObserver constructor.
     * @param EntityMappingService $entityMappingService
     */
    public function __construct(EntityMappingService $entityMappingService)
    {
        $this->entityMappingService = $entityMappingService;
    }

    /**
     * @param EntityNote $entityNote
     */
    public function saving(EntityNote $entityNote)
    {
        $entityNote->entry = $this->purify(Mentions::codify($entityNote->entry));

        // Is private hook for non-admin (who can't set is_private)
        if (!isset($entityNote->is_private)) {
            $entityNote->is_private = false;
        }
    }

    /**
     * @param EntityNote $entityNote
     */
    public function saved(EntityNote $entityNote)
    {
        if (!$entityNote->savedObserver) {
            return;
        }

        // When adding or changing an entity note to an entity, we want to update the
        // last updated date to reflect changes in the dashboard.
        $entityNote->entity->child->savingObserver = false;
        $entityNote->entity->child->touch();

        // If the entity note's entry has changed, we need to re-build it's map.
        if ($entityNote->isDirty('entry')) {
            $this->entityMappingService->mapEntityNote($entityNote);
        }
    }

    /**
     * @param EntityNote $entityNote
     */
    public function deleted(EntityNote $entityNote)
    {
        // When deleting an entity note, we want to update the entity's last update
        // for the dashboard. Careful of this when deleting an entity, we could be
        // entering a non-ending loop.
        if ($entityNote->entity) {
            $entityNote->entity->child->touch();
        }
    }
}
