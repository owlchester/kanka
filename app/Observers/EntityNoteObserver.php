<?php

namespace App\Observers;

use App\Models\EntityNote;
use App\Models\Event;
use App\Models\MiscModel;
use App\Services\ImageService;
use App\Services\LinkerService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Stevebauman\Purify\Purify;

class EntityNoteObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     * @param EntityNote $entityNote
     */
    public function creating(EntityNote $entityNote)
    {
        $entityNote->created_by = Auth::user()->id;
    }

    /**
     * @param EntityNote $entityNote
     */
    public function saving(EntityNote $entityNote)
    {
        $entityNote->entry = $this->purify($entityNote->entry);

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
        // When adding or changing an entity note to an entity, we want to update the
        // last updated date to reflect changes in the dashboard.
        $entityNote->entity->child->touch();
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
