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
}
