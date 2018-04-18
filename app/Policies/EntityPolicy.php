<?php

namespace App\Policies;

use App\Campaign;
use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\Models\Entity;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EntityPolicy
{
    use HandlesAuthorization;

    protected static $cached = [];

    protected $model = '';

    public function browse(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the entity.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Entity  $entity
     * @return mixed
     */
    public function view(User $user, $entity)
    {
        return
            // The entity's campaign must be the same as the current user campaign
            $user->campaign->id == $entity->campaign_id
            &&
            // The user must have access.
            // isAdmin could be cached for performance, but needs to trigger a release when changing permissions
            // other permissions should albo be cachable with a release trigger
            $this->checkPermission('read', $user, $entity);
    }

    /**
     * Determine whether the user can create entitys.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->checkPermission('add', $user);
    }

    /**
     * Determine whether the user can update the entity.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Entity  $entity
     * @return mixed
     */
    public function update(User $user, $entity)
    {
        return $user->campaign->id == $entity->campaign_id && $this->checkPermission('edit', $user, $entity);
    }

    /**
     * Determine whether the user can delete the entity.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Entity  $entity
     * @return mixed
     */
    public function delete(User $user, $entity)
    {
        return $user->campaign->id == $entity->campaign_id && $this->checkPermission('delete', $user, $entity);
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function attribute(User $user, $entity, $subAction = 'browse')
    {
        return $this->relatedElement($user, $entity, $subAction);
    }

    public function relatedElement(User $user, $entity, $subAction = 'browse')
    {
        if ($subAction == 'browse') {
            return $this->view($user, $entity);
        } else {
            return $this->update($user, $entity);
        }
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function relation(User $user, $entity, $subAction = 'browse')
    {
        return $this->relatedElement($user, $entity, $subAction);
    }

    /**
     * Determine whether the user can update the entity.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Entity  $entity
     * @return mixed
     */
    public function permission(User $user, $entity)
    {
        return $user->campaign->id == $entity->campaign_id &&
            ($user->campaign->roles()->count() > 1 || $user->campaign->members()->count() > 1) &&
            $this->checkPermission('permission', $user, $entity);
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function move(User $user, $entity)
    {
        return $this->update($user, $entity);
    }

    /**
     * @param string $action
     * @param User $user
     * @param Entity|null $entity
     * @return bool
     */
    protected function checkPermission($action, User $user, $entity = null)
    {
        $key = $this->model . '_' . $action;
        if (isset(self::$cached[$key])) {
            return self::$cached[$key];
        }

        // Check for the entity too
        if (!empty($entity)) {
            $entityKey = $key . '_' . $entity->id;
            if (isset(self::$cached[$entityKey])) {
                return self::$cached[$entityKey];
            }
        }


        // Want to get my user's permissions and roles
        $keys = [$key];
        // If we've specified an entity, it could be that our role or user has permissions on it
        if (!empty($entity)) {
            $keys[] = $this->model . '_' . $action . '_' . $entity->id;
        }

        // Loop through the roles to build a list of ids, and check if one of our roles is an admin
        $roleIds = [];
        foreach ($user->roles as $role) {
            if ($role->is_admin) {
                return true;
            }
            $roleIds[] = $role->id;
        }

        // Check for a permission related to this action.
        $value = CampaignPermission::whereIn('key', $keys)
            ->where(function ($query) use ($user, $roleIds) {
                return $query->where(['user_id' => $user->id])->orWhereIn('campaign_role_id', $roleIds);
            })->count() > 0;

        // Cache the result
        self::$cached[$key] = $value;

        return $value;
    }
}
