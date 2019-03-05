<?php

namespace App\Services;

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
    public function entityIds()
    {
        $this->loadPermissions();
        return $this->entityIds;
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

        // Have a user? Get their roles in this campaign.
        $roles = 0;
        if ($this->user) {
            /** @var CampaignRole $role */
            foreach ($this->user->campaignRoles as $role) {
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
                if (!in_array($permission->entity_id, $this->entityIds)) {
                    $this->entityIds[] = $permission->entity_id;
                }
            }
        }

        // If the user has no roles in this campaign, they might be in Public mode
        if ($roles == 0) {
            // Get the campaign based on what's in the url
            $campaign = \App\Facades\CampaignLocalization::getCampaign();

            // Go and get the Public role
            $publicRole = $campaign->roles()->where('is_public', true)->first();
            if ($publicRole) {
                $this->parseRole($publicRole);
            }
        }

        return true;
    }

    /**
     * Load the permissions of a roal into the service
     * @param CampaignRole $role
     */
    protected function parseRole(CampaignRole $role)
    {
        // Loop through the permissions of the role to get any blanket _read permissions on entities
        /** @var CampaignPermission $permission */
        foreach ($role->permissions as $permission) {
            // Only test permissions who's action is being requested
            if (!$permission->action() == $this->action) {
                continue;
            }

            if (empty($permission->entity_id)) {
                // This permission targets an entity type
                $type = Str::singular($permission->table_name);
                if (!in_array($type, $this->entityTypes)) {
                    $this->entityTypes[] = $type;
                }
            } elseif (!in_array($permission->entity_id, $this->entityIds)) {
                // This permission targets an entity directly
                $this->entityIds[] = $permission->entity_id;
            }
        }
    }
}
