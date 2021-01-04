<?php

namespace App\Observers;

use App\Facades\Mentions;
use App\Models\EntityNote;
use App\Models\EntityNotePermission;
use App\Services\EntityMappingService;
use Illuminate\Support\Arr;
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

        if ($entityNote->is_pinned) {
            if (empty($entityNote->position)) {
                $last = $entityNote->entity->notes()->pinned()
                    ->orderBy('position', 'desc')
                    ->first();
                $entityNote->position = $last ? $last->position + 1 : 1;
            }
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

        $this->savePermissions($entityNote);

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

    /**
     * @param EntityNote $entityNote
     * @return false
     */
    public function savePermissions(EntityNote $entityNote)
    {
        if (!request()->has('permissions') || !auth()->user()->isAdmin()) {
            return false;
        }

        $existing = $parsedUsers = [];
        foreach ($entityNote->permissions as $perm) {
            $existing[$perm->user_id] = $perm;
        }

        $users = request()->post('perm_user', []);
        $perms = request()->post('perm_perm', []);

        foreach ($users as $key => $user) {
            if ($user == '$USERID$') {
                continue;
            }
            if (isset($existing[$user])) {
                $perm = $existing[$user];
                $perm->permission = $perms[$key];
                $perm->save();
                unset($existing[$user]);
                $parsedUsers[] = $user;
            }
            elseif (!in_array($user, $parsedUsers)) {
                EntityNotePermission::create([
                    'entity_note_id' => $entityNote->id,
                    'user_id' => $user,
                    'permission' => $perms[$key]
                ]);
                $parsedUsers[] = $user;
            }
        }

        // Cleanup permissions that are no longer used
        foreach ($existing as $perm) {
            $perm->delete();
        }
    }
}
