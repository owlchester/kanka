<?php

namespace App\Observers;

use App\Facades\Mentions;
use App\Models\EntityNotePermission;
use App\Models\Post;
use App\Services\EntityMappingService;
use App\Facades\Identity;
use App\Models\EntityLog;

class PostObserver
{
    use PurifiableTrait;
    use ReorderTrait;

    /**
     * Service used to build the map of the entity
     */
    protected EntityMappingService $entityMappingService;

    /**
     * @param EntityMappingService $entityMappingService
     */
    public function __construct(EntityMappingService $entityMappingService)
    {
        $this->entityMappingService = $entityMappingService;
    }

    /**
     * @param Post $post
     */
    public function saving(Post $post)
    {
        $post->entry = $this->purify(Mentions::codify($post->entry));

        // Is private hook for non-admin (who can't set is_private)
        if (!isset($post->is_private)) {
            $post->is_private = false;
        }

        $settings = $post->settings;
        if (request()->has('settings[collapse]')) {
            if ((bool) request()->get('settings[collapse]')) {
                $settings['collapse'] = true;
            } else {
                unset($settings['collapse']);
            }
        }
        $post->settings = $settings;
    }

    /**
     * @param Post $post
     */
    public function created(Post $post)
    {
        $this->log($post, EntityLog::ACTION_CREATE_POST);
        //dd($log);

        //$entity->is_created_now = true;
    }

    /**
     * @param Post $post
     */
    public function updated(Post $post)
    {
        // Don't log updates if just did one (typically when creating, restoring or bulk editing)
        if (!$post->entity->hasUpdateLog() || $post->updated_at == $post->created_at || !empty($post->getOriginal('deleted_at'))) {
            return;
        }

        $this->log($post, EntityLog::ACTION_UPDATE_POST);
    }

    /**
     * @param Post $post
     */
    public function saved(Post $post)
    {
        $this->savePermissions($post);
        if (request()->filled('position')) {
            $this->reorder($post);
        }
        // When adding or changing an entity note to an entity, we want to update the
        // last updated date to reflect changes in the dashboard.
        $post->entity->touchSilently();
        $post->entity->child->touchSilently();

        // If the entity note's entry has changed, we need to re-build it's map.
        if ($post->isDirty('entry')) {
            $this->entityMappingService->mapPost($post);
        }
    }

    /**
     * @param Post $post
     */
    public function deleted(Post $post)
    {
        $this->log($post, EntityLog::ACTION_DELETE_POST);

        // When deleting an entity note, we want to update the entity's last update
        // for the dashboard. Careful of this when deleting an entity, we could be
        // entering a non-ending loop.
        if ($post->entity) {
            $post->entity->touchSilently();
            $post->entity->child->touchSilently();
        }
    }
    /**
     * @param Post $post
     * @param int $action
     */
    private function log(Post $post, int $action)
    {
        $log = new EntityLog();
        $log->entity_id = $post->entity->id;
        $log->created_by = auth()->user()->id;
        if ($action !=  EntityLog::ACTION_DELETE_POST) {
            $log->post_id = $post->id;
        }
        $log->impersonated_by = Identity::getImpersonatorId();
        $log->action = $action;
        $log->save();
    }
    /**
     * @param Post $post
     * @return bool
     */
    public function savePermissions(Post $post): bool
    {
        if (!request()->has('permissions') || !auth()->user()->can('permission', $post->entity->child)) {
            return false;
        }

        $existing = $parsed = [];
        foreach ($post->permissions as $perm) {
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
            } elseif (!in_array($existingKey, $parsed)) {
                EntityNotePermission::create([
                    'post_id' => $post->id,
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
            } elseif (!in_array($existingKey, $parsed)) {
                EntityNotePermission::create([
                    'post_id' => $post->id,
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

        return true;
    }
}
