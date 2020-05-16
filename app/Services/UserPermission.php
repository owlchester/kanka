<?php

namespace App\Services;

use App\Facades\CampaignCache;
use App\Facades\UserCache;
use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\User;
use Illuminate\Support\Str;

class UserPermission
{
    /**
     * @var \Illuminate\Foundation\Application|mixed
     */
    protected $app;

    /**
     * @var User
     */
    protected $user;

    /**
     * Array of Entity IDs the user can access
     * @var array
     */
    protected $entityIds = [];

    /**
     * Array of Entity IDs the user can specifically not access
     * @var array
     */
    protected $deniedEntityIds = [];

    /**
     * Array of Entity Types (journals, characters) the user can access
     * @var array
     */
    protected $entityTypes = [];

    /**
     * Flat defining if the current user is an admin in the requested campaign
     * @var bool
     */
    protected $userCampaignOwner = false;

    /**
     * The ACL action that needs to be tested
     * @var string
     */
    protected $action = 'read';

    /**
     * Flag to know if permissions need to be (re)loaded
     * @var bool
     */
    protected $reload = true;

    /**
     * Create a new instance
     *
     * UserPermission constructor.
     */
    public function __construct()
    {
        $this->app = app();
    }

    /**
     * Set the user
     * @param User $user
     * @return $this
     */
    public function user(User $user = null)
    {
        // If we don't have a user passed and haven't set one either, assume we want the current logged in user.
        if (empty($user) && empty($this->user)) {
            // If the user is logged in, good. We'll use their roles.
            if (auth()->check()) {
                $this->user = auth()->user();
            }
        }

        // Reusing the same user as a previous call? Don't reset everything.
        if (empty($user) || (!empty($this->user) && $this->user->id == $user->id)) {
            return $this;
        }

        // Reset any existing permissions
        $this->reload = true;

        return $this;
    }

    /**
     * Set the ACL action we want to test
     * @param $action
     */
    public function action($action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCampaignOwner()
    {
        $this->loadPermissions();
        return $this->userCampaignOwner;
    }

    /**
     * List of unique entity ids the user has access to
     * @return array
     */
    public function entityIds(): array
    {
        $this->loadPermissions();
        return $this->entityIds;
    }

    /**
     * List of unique entity ids the user has access to
     * @return array
     */
    public function deniedEntityIds(): array
    {
        $this->loadPermissions();
        return $this->deniedEntityIds;
    }

    /**
     * List of entity types the user has a blanket access to
     * @return array
     */
    public function entityTypes()
    {
        $this->loadPermissions();
        return $this->entityTypes;
    }

    /**
     * Load the permissions of the user (roles and personal permissions)
     * @return bool
     */
    private function loadPermissions()
    {
        // Don't require a reload of permissions
        if (!$this->reload) {
            return true;
        }

        $this->entityIds = [];
        $this->entityTypes = [];
        $this->userCampaignOwner = false;
        $this->reload = false;
        $campaign = \App\Facades\CampaignLocalization::getCampaign();

        // Have a user? Get their roles in this campaign.
        $roles = 0;
        if ($this->user) {
            /** @var CampaignRole $role */
            foreach (UserCache::user($this->user)->roles()->where('campaign_id', $campaign->id) as $role) {
                // If one of the roles is an admin, we don't need to figure any more stuff, we're good.
                $roles++;
                if ($role->is_admin) {
                    $this->userCampaignOwner = true;
                    return true;
                }
                $this->parseRole($role);
            }

            // If we have a user, they might have individual entity permissions
            foreach (CampaignPermission::where('user_id', $this->user->id)->get() as $permission) {
                /** @var $permission CampaignPermission */
                // If the permission set is negative, we need to add it to the denied ones too, in case a role of
                // the user has access to this entity.
                if ($permission->access) {
                    if (!in_array($permission->entity_id, $this->entityIds)) {
                        $this->entityIds[] = $permission->entity_id;
                    }
                    // If the user was denied through a role but has access through a direct permissions, still allow them
                    if (($key = array_search($permission->entity_id, $this->deniedEntityIds)) !== false) {
                        unset($this->deniedEntityIds[$key]);
                    }
                } elseif (!$permission->access && !in_array($permission->entity_id, $this->deniedEntityIds)) {
                    $this->deniedEntityIds[] = $permission->entity_id;
                }
            }
        }

        // If the user has no roles in this campaign, they might be in Public mode
        if ($roles == 0) {
            // Get the campaign based on what's in the url
            $campaign = \App\Facades\CampaignLocalization::getCampaign();

            // Go and get the Public role
            $publicRole = CampaignCache::campaign($campaign)->roles()->where('is_public', true)->first();
            if ($publicRole) {
                $this->parseRole($publicRole);
            }
        }

        return true;
    }

    /**
     * Load the permissions of a role into the service
     * @param CampaignRole $role
     */
    protected function parseRole(CampaignRole $role)
    {
        // Loop through the permissions of the role to get any blanket _read permissions on entities
        /** @var CampaignPermission $permission */
        foreach ($role->permissions as $permission) {
            // Only test permissions who's action is being requested
            if ($permission->action() != $this->action) {
                continue;
            }

            if (empty($permission->entity_id)) {
                // This permission targets an entity type
                $type = Str::singular($permission->table_name);
                if (!in_array($type, $this->entityTypes)) {
                    $this->entityTypes[] = $type;
                }
            } elseif ($permission->access && !in_array($permission->entity_id, $this->entityIds)) {
                // This permission targets an entity directly
                $this->entityIds[] = $permission->entity_id;
            } elseif (!$permission->access && !in_array($permission->entity_id, $this->deniedEntityIds)) {
                // This permission targets an entity directly
                $this->deniedEntityIds[] = $permission->entity_id;
            }
        }
    }
}
