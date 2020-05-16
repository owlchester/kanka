<?php

namespace App\Services;

use App\Facades\CampaignCache;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\Models\Entity;
use App\Models\MiscModel;
use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

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

    /**
     * @var bool permissions were loaded
     */
    protected $loadedAll = false;

    /**
     * @var int campaign id of the loaded permissions (required for when moving entities between campaigns)
     */
    protected $loadedCampaignId = 0;

    /**
     * True if the user granted themselves permissions
     * @var bool
     */
    public $granted = false;

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
     * Get list of entity ids for a given model type that the user can access.
     * @param string $modelName
     * @param string $action = 'read'
     * @return array
     */
    public function entityIds(string $modelName, string $action = 'read'): array
    {
        // Check if we have this model type at all
        $modelIds = Arr::get($this->cachedEntityIds, $modelName, []);
        if (empty($modelIds)) {
            return [];
        }
        $ids = [];
        foreach ($modelIds as $id => $data) {
            if (!is_array($data)) {
                // This will throw an error
            }
            foreach ($data as $perm => $access) {
                if ($perm === $action && $access) {
                    $ids[] = $id;
                }
            }
        }
        return $ids;
    }

    /**
     * Entity IDs the user specifically doesn't have access to
     * @param string $modelName
     * @param string $action
     * @return array
     */
    public function deniedEntityIds(string $modelName, string $action = 'read'): array
    {
        // Check if we have this model type at all
        $modelIds = Arr::get($this->cachedEntityIds, $modelName, []);
        if (empty($modelIds)) {
            return [];
        }
        $ids = [];
        foreach ($modelIds as $id => $data) {
            if (!is_array($data)) {
                // This will throw an error
            }
            foreach ($data as $perm => $access) {
                if ($perm === $action && !$access) {
                    $ids[] = $id;
                }
            }
        }
        return $ids;
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
     * @param string $modelName
     * @param string $action
     * @param User $user
     * @param null $entity
     * @param Campaign|null $campaign
     * @return bool
     */
    public function hasPermission(string $modelName, string $action, User $user = null, $entity = null, Campaign $campaign = null)
    {
        $this->loadAllPermissions($user, $campaign);

        if ($this->userIsAdmin) {
            return true;
        }

        // Check if we have permission to `action` all of the entities of this type first. The user
        // might be able to view all quests, but have a specific quest set to denied. This is why
        // we need to check the specific permissions too.
        $key = $modelName . '_' . $action;
        $perm = false;
        if (isset($this->cached[$key]) && $this->cached[$key]) {
            $perm = $this->cached[$key];
        }

        // Check if we have permission for `action` exactly for this entity
        if (!empty($entity)) {
            $entityKey = $key . '_' . $entity->id;
            if (isset($this->cached[$entityKey])) {
                $perm = $this->cached[$entityKey];
            }
        }

        return $perm;
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
                $this->roles = UserCache::user($user)
                    ->roles()
                    ->where('campaign_id', $campaign->id);
            }

            // If we don't have a user, or our user has no specified role yet, use the public role.
            if ($this->roles === false || $this->roles->count() == 0) {
                // Use the campaign's public role
                $this->roles = CampaignCache::campaign($campaign)
                    ->roles()
                    ->where('is_public', true);
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

        // We check if the role was set for global entity permissions
        if (isset($this->cached[$key]) && $this->cached[$key]) {
            return $this->cached[$key];
        }

        return false;
    }

    /**
     * Grant a permission ad-hoc
     * @param Entity $entity
     * @param string $action
     * @return $this
     */
    public function grant(Entity $entity, string $action = 'read'): self
    {
        $this->granted = true;
        $this->cachedEntityIds[$entity->type][$entity->entity_id][$action] = true;
        return $this;
    }

    /**
     * @return bool
     */
    public function granted(): bool
    {
        return $this->granted;
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
        // If no campaign was provided, get the one in the url. One is provided when moving entities between campaigns
        if (empty($campaign)) {
            $campaign = \App\Facades\CampaignLocalization::getCampaign();
            // Our Campaign middleware takes care of this, but the laravel binding is going to get the model first
            // so we have to add this abort here to handle calling the permission engine on campaigns which
            // no longer exist.
            if (empty($campaign)) {
                abort(404);
            }
        }

        if ($this->loadedAll === true && $campaign->id == $this->loadedCampaignId) {
            return;
        }

        // Reset the values keeping score
        $this->loadedAll = true;
        $this->loadedCampaignId = $campaign->id;
        $this->cached = [];
        $this->roleIds = false;
        $this->userIsAdmin = false;

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
                $this->cached[$permission->key] = $permission->access;
                if (!empty($permission->entity_id)) {
                    $this->cachedEntityIds[$permission->type()][$permission->entityId()][$permission->action()] = (bool) $permission->access;
                }
            }
        }

        // If a user is provided, get their permissions too
        if (!empty($user)) {
            foreach ($user->permissions as $permission) {
                $this->cached[$permission->key] = $permission->access;
                if (!empty($permission->entity_id)) {
                    $this->cachedEntityIds[$permission->type()][$permission->entityId()][$permission->action()] = (bool) $permission->access;
                }
            }
        }

//        dump($this->cachedEntityIds);
    }
}
