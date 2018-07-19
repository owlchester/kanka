<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\CampaignPermission;

class EntityPermission
{
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
    protected $roles = false;

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
     * Determine the permission for a user to interact with an entity
     *
     * @param string $locale Locale to set the App to (optional)
     *
     * @return string Returns locale (if route has any) or null (if route does not have a locale)
     */
    public function hasPermission($modelName, $action, $user = null, $entity = null, Campaign $campaign = null)
    {
        $key = $modelName . '_' . $action;
        // If cached on whole entities and we have read access, we're goot!
        if (isset($this->cached[$key]) && $this->cached[$key]) {
            return $this->cached[$key];
        }

        // Check for the entity too
        if (!empty($entity)) {
            $entityKey = $key . '_' . $entity->id;
            if (isset($this->cached[$entityKey])) {
                return $this->cached[$entityKey];
            }
        }

        // Want to get my user's permissions and roles
        $keys = [$key];
        // If we've specified an entity, it could be that our role or user has permissions on it
        if (!empty($entity)) {
            $keys[] = $modelName . '_' . $action . '_' . $entity->id;
        }

        // No campaign? Use the user's
        if (empty($campaign) && $user) {
            $campaign = \App\Facades\CampaignLocalization::getCampaign();
        }

        // Loop through the roles to build a list of ids, and check if one of our roles is an admin
        $roleIds = [];
        // This needs to be cached.
        if ($this->roles === false) {
            if ($user) {
                $this->roles = $user->campaignRoles($campaign->id)->get();
            }

            // No roles? Use the public one.
            if ($this->roles === false || $this->roles->count() == 0 ) {
                // Use the campaign's public role
                $this->roles = $campaign->roles()->public()->get();
            }
        }
        foreach ($this->roles as $role) {
            if ($role->is_admin) {
                return true;
            }
            $roleIds[] = $role->id;
        }

        // Check for a permission related to this action.
        $value = false;

        $permissions = null;
        if ($user) {
            $permissions = CampaignPermission::whereIn('key', $keys)
                ->where(function ($query) use ($user, $roleIds) {
                    return $query->where(['user_id' => $user->id])->orWhereIn('campaign_role_id', $roleIds);
                })->get();
        } else {
            $permissions = CampaignPermission::whereIn('key', $keys)
                ->whereIn('campaign_role_id', $roleIds)
                ->get();
        }
        foreach ($permissions as $permission) {
            // If we got a permission for the exact entity, save that
            if (isset($keys[1]) && strpos($permission->key, $keys[1]) !== false) {
                $key = $keys[1];
            }
            $value = true;
        }

        // Cache the result
        $this->cached[$key] = $value;

        return $value;
    }
}
