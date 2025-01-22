<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Facades\EntityPermission;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EntityPolicy
{
    use HandlesAuthorization;

    public function view(?User $user, Entity $entity): bool
    {
        return EntityPermission::entity($entity)->user($user)->can(Permission::View);
    }
    public function update(User $user, Entity $entity): bool
    {
        return EntityPermission::entity($entity)->user($user)->can(Permission::Update);
    }


    public function attributes(?User $user, Entity $entity): bool
    {
        if ($entity->exists === false) {
            return true;
        }
        return !$entity->is_attributes_private || $user && $user->isAdmin();
    }

    public function viewAttributes(?User $user, Entity $entity, Campaign $campaign): bool
    {
        if (!$campaign->enabled('entity_attributes')) {
            return false;
        }

        if (!$entity->is_attributes_private) {
            return true;
        }
        return $user && $user->isAdmin();
    }

    public function privacy(User $user): bool
    {
        return $user->isAdmin();
    }

    public function history(User $user, Entity $entity, Campaign $campaign): bool
    {
        return $user->isAdmin() || !($campaign->boosted() && $campaign->hide_history);
    }

    public function move(User $user, Entity $entity): bool
    {
        return $this->update($user, $entity);
    }

    public function inventory(User $user, Entity $entity): bool
    {
        return $this->update($user, $entity);
    }

    public function relation(User $user, Entity $entity): bool
    {
        return $this->update($user, $entity);
    }

    public function permissions(User $user, Entity $entity): bool
    {
        return EntityPermission::entity($entity)->user($user)->can(Permission::Permissions);
    }

    public function post(User $user, Entity $entity, string $action = null, ?Post $post = null): bool
    {
        return (
            $this->update($user, $entity) ||
            EntityPermission::entity($entity)->user($user)->can(Permission::Posts) ||
            ($action == 'edit' ? $this->checkPostPermission($user, $post) : false)
        ) ;
    }

    public function delete(User $user, Entity $entity): bool
    {
        return  EntityPermission::entity($entity)->user($user)->can(Permission::Delete);
    }

    public function reminders(User $user, Entity $entity): bool
    {
        return $this->update($user, $entity);
    }


    /**
     */
    protected function checkPostPermission(User $user, Post $post): bool
    {
        $roleIds = UserCache::roles()->pluck('id')->toArray();
        $perms = $post->permissions->where('permission', 1);
        return $perms->where('user_id', $user->id)->count() == 1
            ||
            $perms->whereIn('role_id', $roleIds)->count() == 1
        ;
    }
}
