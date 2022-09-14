<?php

namespace App\Services;

use App\Http\Requests\MovePostRequest;
use App\Models\Campaign;
use App\Models\EntityNote;
use Illuminate\Support\Arr;

class EntityNoteService
{
    /** @var Campaign */
    protected Campaign $campaign;

    /** @var EntityMappingService */
    protected EntityMappingService $mappingService;

    public function __construct(EntityMappingService $mappingService)
    {
        $this->mappingService = $mappingService;
    }

/**
     * Move or copy an entity note to another entity
     *
     * @param EntityNote $entityNote
     * @param MovePostRequest $request
     * @return EntityNote
     */
    public function moveEntityNote(EntityNote $entityNote, MovePostRequest $request): EntityNote
    {
        if ($request->has('copy')) {
            $newNote = $entityNote->replicate();
            $newNote->entity_id = $request->get('entity');
            $newNote->savedObserver = false;
            $newNote->save();

            // Also replicate permissions
            foreach ($entityNote->permissions as $perm) {
                $newPerm = $perm->replicate(['entity_note_id']);
                $newPerm->entity_note_id = $newNote->id;
                $newPerm->save();
            }

            // Update the "mentioned in" mapping for the entity
            $this->mappingService->mapEntityNote($newNote);

            return $newNote;
        }

        $entityNote->entity_id = $request->get('entity');
        $entityNote->save();


        return $entityNote;
    }
}
