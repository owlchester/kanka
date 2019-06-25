<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\Models\Entity;
use App\Models\MiscModel;
use App\User;

class EntityPermission
{
    /**
     * @var MiscModel
     */
    protected $model;

    /**
     * @var \Illuminate\Foundation\Application|mixed
     */
    protected $app;

    /**
     * @var array
     */
    protected $cached = [];

    /**
     * @var array|boolean
     */
    protected $roleIds = false;

    /**
     * @var array The roles of the user
     */
    protected $roles = [];

    /**
     * @var array Entity Ids
     */
    protected $cachedEntityIds = [];

    /**
     * @var bool is admin
     */
    protected $userIsAdmin = null;

    protected $loadedAll = false;

    /**
     * Creates new instance.
     *
     * @throws UnsupportedLocaleException
     */
    public function __construct()
    {
        $this->app = app();
    }

    /**
     * @param Entity $entity
     * @param Campaign|null $campaign
     * @return bool
     */
    public function canView(Entity $entity, Campaign $campaign = null)
    {
        // Make sure we can see the entity we're trying to show the user. We do it this way because we
        // are looping through entities which doesn't allow using the acl trait before hand.
        if (auth()->check()) {
            return auth()->user()->can('view', $entity->child);
        } elseif (!empty($entity->child)) {
            return self::hasPermission($entity->child->getEntityType(), 'read', null, $entity->child, $campaign);
        }
        return false;
    }

    /**
     * @param MiscModel $model
     * @param Campaign|null $campaign
     * @return bool
     */
    public function canViewMisc(MiscModel $model, Campaign $campaign = null)
    {
        // Make sure we can see the entity we're trying to show the user. We do it this way because we
        // are looping through entities which doesn't allow using the acl trait before hand.
        if (auth()->check()) {
            return auth()->user()->can('view', $model);
        } elseif (!empty($model)) {
            return self::hasPermission($model->getEntityType(), 'read', null, $model, $campaign);
        }
        return false;
    }

    /**
     * Determine the permission for a user to interact with an entity
     * @param $modelName
     * @param $action
     * @param null $user
     * @param null $entity
     * @param Campaign|null $campaign
     * @return bool
     */
    public function hasPermission($modelName, $action, $user = null, $entity = null, Campaign $campaign = null)
    {
        $this->loadAllPermissions($user, $campaign);

        if ($this->userIsAdmin) {
            return true;
        }

        // Check if we have permission to `action` all of the entities of this type first.
        $key = $modelName . '_' . $action;
        if (isset($this->cached[$key]) && $this->cached[$key]) {
            return $this->cached[$key];
        }

        // Check if we have permission for `action` exactly for this entity
        if (!empty($entity)) {
            $entityKey = $key . '_' . $entity->id;
            if (isset($this->cached[$entityKey])) {
                return $this->cached[$entityKey];
            }
        }

        return false;
    }

    /**
     * Check the roles of the user. If the user is an admin, always return true
     * @param Campaign $campaign
     * @param User|null $user
     * @return array|bool
     */
    protected function getRoleIds(Campaign $campaign, User $user = null)
    {
        // If we haven't built a list of roles yet, build it.
        if ($this->roleIds === false) {
            $this->roles = false;
            // If we have a user, get the user's role for this campaign
            if ($user) {
                $this->roles = $user->campaignRoles($campaign->id)
                    ->with('permissions')
                    ->get();
            }

            // If we don't have a user, or our user has no specified role yet, use the public role.
            if ($this->roles === false || $this->roles->count() == 0) {
                // Use the campaign's public role
                $this->roles = $campaign->roles()
                    ->public()
                    ->with('permissions')
                    ->get();
            }

            // Save all the role ids. If one of them is an admin, stop there.
            $this->roleIds = [];
            /** @var CampaignRole $role */
            foreach ($this->roles as $role) {
                if ($role->is_admin) {
                    $this->roleIds = true;
                    return true;
                }
                $this->roleIds[] = $role->id;
            }
        }

        return $this->roleIds;
    }

    /**
     * Determine if a user is part of a role that can do an action on all entities of a campaign
     * @param string $action
     * @param string $model
     * @return bool
     */
    public function canRole(string $action, string $modelName, $user = null, Campaign $campaign = null): bool
    {
        $this->loadAllPermissions($user, $campaign);
        $key = $modelName . '_' . $action;

        if (isset($this->cached[$key]) && $this->cached[$key]) {
            return $this->cached[$key];
        }

        return false;
    }

    /**
     * It's way easier to just load all permissions of the user once and "cache" them, rather than try and be
     * optional on each query.
     * @param User $user
     * @param Campaign $campaign
     * @return void
     */
    protected function loadAllPermissions(User $user = null, Campaign $campaign = null)
    {
        if ($this->loadedAll === true) {
            return;
        }
        $this->loadedAll = true;

        // If no campaign was provided, get the one in the url.
        if (empty($campaign)) {
            $campaign = \App\Facades\CampaignLocalization::getCampaign();
        }

        // Loop through the roles to build a list of ids, and check if one of our roles is an admin
        $roleIds = $this->getRoleIds($campaign, $user);
        if ($roleIds === true) {
            // If the role ids is simply true, it means the user is an admin
            $this->userIsAdmin = true;
            return;
        }

        /** @var CampaignRole $role */
        foreach ($this->roles as $role) {
            /** @var CampaignPermission $permission */
            foreach ($role->permissions as $permission) {
                $this->cached[$permission->key] = true;
                if (!empty($permission->entity_id)) {
                    $this->cachedEntityIds[$permission->type()][] = $permission->entityId();
                }
            }
        }

        // If a user is provided, get their permissions too
        if (!empty($user)) {
            foreach ($user->permissions as $permission) {
                $this->cached[$permission->key] = true;
                if (!empty($permission->entity_id)) {
                    $this->cachedEntityIds[$permission->type()][] = $permission->entityId();
                }
            }
        }
    }

    /**
     * Get list of entity ids for a given model type that the user can access.
     * @param $modelName
     * @return array
     */
    public function entityIds($modelName)
    {
        return array_get($this->cachedEntityIds, $modelName, [0]);
    }
}
