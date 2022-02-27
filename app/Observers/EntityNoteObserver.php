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
        if (!$entityNote->savingObserver) {
            return;
        }

        $entityNote->entry = $this->purify(Mentions::codify($entityNote->entry));

        // Is private hook for non-admin (who can't set is_private)
        if (!isset($entityNote->is_private)) {
            $entityNote->is_private = false;
        }

        $settings = $entityNote->settings;
        if (request()->has('settings[collapse]')) {
            if ((bool) request()->get('settings[collapse]')) {
                $settings['collapse'] = true;
            } else {
                unset($settings['collapse']);
            }
        }
        $entityNote->settings = $settings;
    }

    /**
     * @param EntityNote $entityNote
     */
    public function creating(EntityNote $entityNote)
    {
        // Make sure we're adding this note at the end of other notes
        $last = $entityNote->entity->notes()
            ->where('id', '!=', $entityNote->id)
            ->orderBy('position', 'desc')
            ->first();
        $entityNote->position = $last ? ($last->position + 1) : 1;
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

        $existing = $parsed = [];
        foreach ($entityNote->permissions as $perm) {
            $key = $perm->isUser() ? 'u_' : 'r_';
            $existing[$key . $perm->user_id] = $perm;
        }

        $users = request()->post('perm_user', []);
        $perms = request()->post('perm_user_perm', []);

        foreach ($users as $key => $user) {
            if ($user == '$SELECTEDID$') {
                continue;
            }

            $existingKey = 'u_' . $user;
            if (isset($existing[$existingKey])) {
                $perm = $existing[$existingKey];
                $perm->permission = $perms[$key];
                $perm->save();
                unset($existing[$existingKey]);
                $parsed[] = $existingKey;
            }
            elseif (!in_array($existingKey, $parsed)) {
                EntityNotePermission::create([
                    'entity_note_id' => $entityNote->id,
                    'user_id' => $user,
                    'permission' => $perms[$key]
                ]);
                $parsed[] = $existingKey;
            }
        }

        $roles = request()->post('perm_role', []);
        $perms = request()->post('perm_role_perm', []);

        foreach ($roles as $key => $user) {
            if ($user == '$SELECTEDID$') {
                continue;
            }

            $existingKey = 'r_' . $user;
            if (isset($existing[$existingKey])) {
                $perm = $existing[$existingKey];
                $perm->permission = $perms[$key];
                $perm->save();
                unset($existing[$existingKey]);
                $parsed[] = $existingKey;
            }
            elseif (!in_array($existingKey, $parsed)) {
                EntityNotePermission::create([
                    'entity_note_id' => $entityNote->id,
                    'role_id' => $user,
                    'permission' => $perms[$key]
                ]);
                $parsed[] = $existingKey;
            }
        }

        // Cleanup permissions that are no longer used
        foreach ($existing as $oldPermission) {
            $oldPermission->delete();
        }
    }
}
