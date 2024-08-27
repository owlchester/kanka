<?php

namespace App\Policies;

use App\Facades\CampaignLocalization;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Facades\EntityPermission;
use App\Models\CampaignPermission;
use App\Models\Entity;
use App\Models\MiscModel;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class MiscPolicy
{
    use HandlesAuthorization;

    /**
     * If a whole model requires a boosted campaign, for example if it's early access, set the child policy's
     * $boosted property to true.
     */
    protected bool $boosted = false;

    public function browse(): bool
    {
        return true;
    }

    public function view(User $user, MiscModel $entity): bool
    {
        if ($this->boosted) {
            $campaign = CampaignLocalization::getCampaign();
            if (!$campaign->boosted()) {
                return false;
            }
        }

        return
            // The user must have access.
            // isAdmin could be cached for performance, but needs to trigger a release when changing permissions
            // other permissions should also be cacheable with a release trigger
            $this->checkPermission(CampaignPermission::ACTION_READ, $user, $entity);
    }

    public function create(User $user, $entity = null, ?Campaign $campaign = null): bool
    {
        if ($this->boosted) {
            $campaign = $campaign ?? CampaignLocalization::getCampaign();
            if (!$campaign->boosted()) {
                return false;
            }
        }

        return auth()->check() && $this->checkPermission(CampaignPermission::ACTION_ADD, $user, null, $campaign);
    }

    public function update(User $user, MiscModel $entity): bool
    {
        return auth()->check()
            && $this->checkPermission(CampaignPermission::ACTION_EDIT, $user, $entity);
    }

    public function delete(User $user, MiscModel $entity): bool
    {
        return auth()->check()
            && $this->checkPermission(CampaignPermission::ACTION_DELETE, $user, $entity);
    }

    public function attribute(?User $user, $entity, string $subAction = 'browse'): bool
    {
        return $this->relatedElement($user, $entity, $subAction);
    }

    public function relatedElement(?User $user, $entity, string $subAction = 'browse'): bool
    {
        if ($subAction == 'browse') {
            return $user && $this->view($user, $entity);
        } else {
            return $user && $this->update($user, $entity) ;
        }
    }

    public function relation(User $user, $entity, string $subAction = 'browse'): bool
    {
        return $this->relatedElement($user, $entity, $subAction);
    }

    public function post(User $user, $entity, string $action = null, ?Post $post = null): bool
    {
        return Auth::check() && (
            $this->update($user, $entity) ||
            $this->checkPermission(CampaignPermission::ACTION_POSTS, $user, $entity) ||
            ($action == 'edit' ? $this->checkPostPermission($user, $post) : false)
        ) ;
    }

    /**
     * Determine whether the user can manage the permissions of the entity
     */
    public function permission(User $user, MiscModel $entity): bool
    {
        if ($entity->exists === false) {
            return $this->checkPermission(CampaignPermission::ACTION_PERMS, $user, null);
        }
        // This previously checked if the campaign had multiple members, but it made it unclear for new
        // users that permissions were possible, obfuscating part of Kanka's strength
        return $this->checkPermission(CampaignPermission::ACTION_PERMS, $user, $entity);
    }

    /**
     */
    public function move(User $user, $entity): bool
    {
        return $this->update($user, $entity);
    }

    /**
     */
    public function events(User $user, $entity): bool
    {
        return $this->update($user, $entity);
    }

    /**
     */
    public function inventory(User $user, $entity): bool
    {
        return $this->update($user, $entity);
    }

    /**
     * @param Entity|MiscModel|null $entity
     */
    protected function checkPermission(int $action, User $user, mixed $entity = null, ?Campaign $campaign = null): bool
    {
        // @phpstan-ignore-next-line
        return EntityPermission::hasPermission($this->entityTypeID(), $action, $user, $entity, $campaign);
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
