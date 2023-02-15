<?php

namespace App\Policies;

use App\Facades\UserCache;
use App\Models\Campaign;
use App\Facades\EntityPermission;
use App\Models\CampaignPermission;
use App\Models\Entity;
use App\Models\MiscModel;
use App\Models\Post;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class MiscPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function browse(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the entity.
     *
     * @param  ?\App\User  $user
     * @param  \App\Models\MiscModel $entity
     * @return bool
     */
    public function view(?User $user, $entity)
    {
        return
            // The user must have access.
            // isAdmin could be cached for performance, but needs to trigger a release when changing permissions
            // other permissions should also be cacheable with a release trigger
            $this->checkPermission(CampaignPermission::ACTION_READ, $user, $entity);
    }

    /**
     * Determine whether the user can create entities.
     * @param ?User $user
     * @param MiscModel|null $entity
     * @param Campaign|null $campaign
     * @return bool
     */
    public function create(?User $user, $entity = null, Campaign $campaign = null)
    {
        if (!$user) {
            return false;
        }
        return $this->checkPermission(CampaignPermission::ACTION_ADD, $user, null, $campaign);
    }

    /**
     * Determine whether the user can update the entity.
     *
     * @param  \App\User  $user
     * @param  \App\Models\MiscModel $entity
     * @return bool
     */
    public function update(?User $user, $entity)
    {
        if (!$user) {
            return false;
        }
        return $this->checkPermission(CampaignPermission::ACTION_EDIT, $user, $entity);
    }

    /**
     * Determine whether the user can delete the entity.
     *
     * @param  \App\User  $user
     * @param  \App\Models\MiscModel $entity
     * @return bool
     */
    public function delete(?User $user, $entity)
    {
        if (!$user) {
            return false;
        }
        return $this->checkPermission(CampaignPermission::ACTION_DELETE, $user, $entity);
    }

    /**
     * Determine whether the user can bulk delete entities of this type
     *
     * @param  ?\App\User  $user
     * @param  \App\Models\MiscModel $entity
     * @return bool
     */
    public function bulkDelete(?User $user, $entity)
    {
        if (!$user) {
            return false;
        }
        return $this->checkPermission(CampaignPermission::ACTION_DELETE, $user, $entity);
    }

    /**
     * @param User|null $user
     * @param MiscModel $entity
     * @param string $subAction
     * @return bool
     */
    public function attribute(?User $user, $entity, string $subAction = 'browse')
    {
        return $this->relatedElement($user, $entity, $subAction);
    }

    /**
     * @param User $user
     * @param MiscModel $entity
     * @param string $subAction
     * @return bool
     */
    public function relatedElement(?User $user, $entity, string $subAction = 'browse')
    {
        if ($subAction == 'browse') {
            return $user && $this->view($user, $entity);
        } else {
            return $user && $this->update($user, $entity) ;
        }
    }

    /**
     * @param User $user
     * @param MiscModel $entity
     * @param string $subAction
     * @return bool
     */
    public function relation(User $user, $entity, string $subAction = 'browse')
    {
        return $this->relatedElement($user, $entity, $subAction);
    }

    /**
     * @param User $user
     * @param MiscModel $entity
     * @param string|null $action
     * @param Post|null $post
     * @return bool
     */
    public function post(User $user, $entity, string $action = null, Post $post = null)
    {
        return Auth::check() && (
            $this->update($user, $entity) ||
            $this->checkPermission(CampaignPermission::ACTION_POSTS, $user, $entity) ||
            ($action == 'edit' ? $this->checkPostPermission($user, $post) : false)
        ) ;
    }

    /**
     * Determine whether the user can manage the permissions of the entity
     *
     * @param  \App\User  $user
     * @param  \App\Models\MiscModel $entity
     * @return bool
     */
    public function permission(User $user, $entity)
    {
        if ($entity->exists === false) {
            return $this->checkPermission(CampaignPermission::ACTION_PERMS, $user, null);
        }
        // This previously checked if the campaign had multiple members, but it made it unclear for new
        // users that permissions were possible, obfuscating part of Kanka's strength
        return $this->checkPermission(CampaignPermission::ACTION_PERMS, $user, $entity);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function move(User $user, $entity)
    {
        return $this->update($user, $entity);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function events(User $user, $entity)
    {
        return $this->update($user, $entity);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function inventory(User $user, $entity)
    {
        return $this->update($user, $entity);
    }

    /**
     * @param int $action
     * @param User $user
     * @param Entity|MiscModel|null $entity
     * @param Campaign|null $campaign
     * @return bool
     */
    protected function checkPermission(int $action, User $user, $entity = null, Campaign $campaign = null): bool
    {
        return EntityPermission::hasPermission($this->entityTypeID(), $action, $user, $entity, $campaign);
    }

    /**
     * @param User $user
     * @param Post $post
     * @return bool
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
