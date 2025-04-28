<?php

namespace App\Observers;

use App\Facades\Identity;
use App\Models\EntityLog;
use App\Models\Post;
use App\Models\PostPermission;
use App\Services\Entity\PostLoggerService;

class PostObserver
{
    use ReorderTrait;

    /**
     * Service used to log changes to posts
     */
    protected PostLoggerService $postLoggerService;

    public function __construct(PostLoggerService $postLoggerService)
    {
        $this->postLoggerService = $postLoggerService;
    }

    public function saving(Post $post)
    {
        // Is private hook for non-admin (who can't set is_private)
        if (! isset($post->is_private)) {
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

    public function created(Post $post)
    {
        $this->log($post, EntityLog::ACTION_CREATE_POST);

        // $entity->is_created_now = true;
    }

    public function updated(Post $post)
    {
        // Don't log updates if just did one (typically when creating, restoring or bulk editing)
        if (! $post->entity->hasUpdateLog() || $post->updated_at == $post->created_at || ! empty($post->getOriginal('deleted_at'))) {
            return;
        }

        $changes = $this->postLoggerService->postDirty($post);

        $this->log($post, EntityLog::ACTION_UPDATE_POST, $changes);
    }

    public function saved(Post $post)
    {
        $this->savePermissions($post);
        if (request()->filled('position')) {
            $this->reorder($post);
        }
        // When adding or changing a post to an entity, we want to update the
        // last updated date to reflect changes in the dashboard.
        $post->entity->touchSilently();
        if ($post->entity->hasChild()) {
            $post->entity->child->touchSilently();
        }
    }

    public function deleted(Post $post)
    {
        $this->log($post, EntityLog::ACTION_DELETE_POST);

        // When deleting a post, we want to update the entity's last update
        // for the dashboard. Careful of this when deleting an entity, we could be
        // entering a non-ending loop.
        if ($post->entity) {
            $post->entity->touchSilently();
            if ($post->entity->hasChild()) {
                $post->entity->child->touchSilently();
            }
        }
    }

    private function log(Post $post, int $action, array $changes = [])
    {
        $log = new EntityLog;
        $log->entity_id = $post->entity->id;
        $log->created_by = auth()->user()->id;
        if ($action != EntityLog::ACTION_DELETE_POST) {
            $log->post_id = $post->id;
        }
        $log->impersonated_by = Identity::getImpersonatorId();
        $log->action = $action;
        if (! empty($changes)) {
            $log->changes = $changes;
        }
        $log->save();
    }

    public function savePermissions(Post $post): bool
    {
        if (! request()->has('permissions') || ! auth()->user()->can('permissions', $post->entity)) {
            return false;
        }

        $existing = $parsed = [];
        foreach ($post->permissions as $perm) {
            $key = $perm->isUser() ? 'u_' : 'r_';
            $existing[$key . $perm->user_id] = $perm;
        }

        $users = (array) request()->post('perm_user', []);
        $perms = (array) request()->post('perm_user_perm', []);

        foreach ($users as $key => $user) {
            if ($user == '$SELECTEDID$') {
                continue;
            }

            $existingKey = 'u_' . $user;
            if (isset($existing[$existingKey])) {
                $perm = $existing[$existingKey];
                $perm->permission = (int) $perms[$key];
                $perm->save();
                unset($existing[$existingKey]);
                $parsed[] = $existingKey;
            } elseif (! in_array($existingKey, $parsed)) {
                PostPermission::create([
                    'post_id' => $post->id,
                    'user_id' => $user,
                    'permission' => $perms[$key],
                ]);
                $parsed[] = $existingKey;
            }
        }

        $roles = (array) request()->post('perm_role', []);
        $perms = (array) request()->post('perm_role_perm', []);

        foreach ($roles as $key => $user) {
            if ($user == '$SELECTEDID$') {
                continue;
            }

            $existingKey = 'r_' . $user;
            if (isset($existing[$existingKey])) {
                $perm = $existing[$existingKey];
                $perm->permission = (int) $perms[$key];
                $perm->save();
                unset($existing[$existingKey]);
                $parsed[] = $existingKey;
            } elseif (! in_array($existingKey, $parsed)) {
                PostPermission::create([
                    'post_id' => $post->id,
                    'role_id' => $user,
                    'permission' => $perms[$key],
                ]);
                $parsed[] = $existingKey;
            }
        }

        // Cleanup permissions that are no longer used
        foreach ($existing as $oldPermission) {
            $oldPermission->delete();
        }

        if (! $post->isDirty()) {
            $this->log($post, EntityLog::ACTION_UPDATE_POST);
        }

        return true;
    }
}
