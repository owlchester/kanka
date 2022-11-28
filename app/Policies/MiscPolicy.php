<?php

namespace App\Policies;

use App\Facades\CampaignLocalization;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Facades\EntityPermission;
use App\Models\CampaignPermission;
use App\Models\Entity;
use App\Models\EntityNote;
use App\Models\MiscModel;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class MiscPolicy
{
    use HandlesAuthorization;

    /**
     * If a whole model requires a boosted campaign, for example if it's early access, set the child policy's
     * $boosted property to true.
     * @var bool
     */
    protected bool $boosted = false;

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
     * @param  \App\User  $user
     * @param  \App\Models\MiscModel $entity
     * @return bool
     */
    public function view(User $user, $entity)
    {
        if ($this->boosted) {
            $campaign = CampaignLocalization::getCampaign();
            if (!$campaign->boosted()) {
                return false;
            }
        }

        return
            // The entity's campaign must be the same as the current user campaign
            $user->campaign->id == $entity->campaign_id
            &&
            // The user must have access.
            // isAdmin could be cached for performance, but needs to trigger a release when changing permissions
            // other permissions should also be cacheable with a release trigger
            $this->checkPermission(CampaignPermission::ACTION_READ, $user, $entity);
    }

    /**
     * Determine whether the user can create entities.
     * @param User $user
     * @param MiscModel|null $entity
     * @param Campaign|null $campaign
     * @return bool
     */
    public function create(User $user, $entity = null, Campaign $campaign = null)
    {
        if ($this->boosted) {
            $campaign = CampaignLocalization::getCampaign();
            if (!$campaign->boosted()) {
                return false;
            }
        }

        return auth()->check() && $this->checkPermission(CampaignPermission::ACTION_ADD, $user, null, $campaign);
    }

    /**
     * Determine whether the user can update the entity.
     *
     * @param  \App\User  $user
     * @param  \App\Models\MiscModel $entity
     * @return bool
     */
    public function update(User $user, $entity)
    {
        return Auth::check() && (!empty($entity->campaign_id) ? $user->campaign->id == $entity->campaign_id : true)
            && $this->checkPermission(CampaignPermission::ACTION_EDIT, $user, $entity);
    }

    /**
     * Determine whether the user can delete the entity.
     *
     * @param  \App\User  $user
     * @param  \App\Models\MiscModel $entity
     * @return bool
     */
    public function delete(User $user, $entity)
    {
        return Auth::check() &&  (!empty($entity->campaign_id) ? $user->campaign->id == $entity->campaign_id : true)
            && $this->checkPermission(CampaignPermission::ACTION_DELETE, $user, $entity);
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
     * @param EntityNote|null $entityNote
     * @return bool
     */
    public function entityNote(User $user, $entity, string $action = null, EntityNote $entityNote = null)
    {
        return Auth::check() && (
            $this->update($user, $entity) ||
            $this->checkPermission(CampaignPermission::ACTION_POSTS, $user, $entity) ||
            ($action == 'edit' ? $this->checkEntityNotePermission($user, $entityNote) : false)
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
     * @param EntityNote $entityNote
     * @return bool
     */
    protected function checkEntityNotePermission(User $user, EntityNote $entityNote): bool
    {
        $roleIds = UserCache::roles()->pluck('id')->toArray();
        $perms = $entityNote->permissions->where('permission', 1);
        return $perms->where('user_id', $user->id)->count() == 1
            ||
            $perms->whereIn('role_id', $roleIds)->count() == 1
        ;
    }
}
