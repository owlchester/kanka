<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\EntityNote;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EntityNoteService
{
    /** @var Campaign */
    protected Campaign $campaign;

/**
     * Move or copy an entity note to another entity
     *
     * @param EntityNote $entity
     * @param array $request
     * @return EntityNote
     */
    public function moveEntityNote(EntityNote $entityNote, array $request): EntityNote
    {
        if (isset($request['copy'])) {
            $newNote = $entityNote->replicate();
            $newNote->entity_id = Arr::get($request, 'entity');
            $newNote->savedObserver = false;
            $newNote->save();

            return $newNote;
        } else {
            $entityNote->entity_id = Arr::get($request, 'entity');
            $entityNote->save();
        }

        return $entityNote;
    }
}