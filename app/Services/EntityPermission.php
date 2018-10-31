<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\CampaignPermission;
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
     * Creates new instance.
     *
     * @throws UnsupportedLocaleException
     */
    public function __construct()
    {
        $this->app = app();
    }

    public function canView(Entity $entity, Campaign $campaign = null)
    {
        // Make sure we can see the entity we're trying to show the user. We do it this way because we
        // are looping through entities which doesn't allow using the acl trait before hand.
        if (auth()->check()) {
            return auth()->user()->can('view', $entity->child);
        } else {
            return self::hasPermission($entity->child->getEntityType(), 'read', null, $entity->child, $campaign);
        }
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

        // Want to get my user's permissions and roles
        $keys = [$key];
        // If we've specified an entity, it could be that our role or user has permissions on it
        if (!empty($entity)) {
            $keys[] = $modelName . '_' . $action . '_' . $entity->id;
        }

        // If no campaign was provided, get the one in the url.
        if (empty($campaign)) {
            $campaign = \App\Facades\CampaignLocalization::getCampaign();
        }

        // Loop through the roles to build a list of ids, and check if one of our roles is an admin
        $roleIds = $this->getRoleIds($campaign, $user);
        if ($roleIds === true) {
            // If the role ids is simply true, it means the user is an admin
            return true;
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

        // Cache the result that gave us access.
        $this->cached[$key] = $value;

        return $value;
    }

    /**
     * @param Campaign $campaign
     * @param User|null $user
     * @return array|bool
     */
    protected function getRoleIds(Campaign $campaign, User $user = null)
    {
        // If we haven't built a list of roles yet, build it.
        if ($this->roleIds === false) {
            $roles = false;
            // If we have a user, get the user's role for this campaign
            if ($user) {
                $roles = $user->campaignRoles($campaign->id)->get();
            }

            // If we don't have a user, or our user has no specified role yet, use the public role.
            if ($roles === false || $roles->count() == 0) {
                // Use the campaign's public role
                $roles = $campaign->roles()->public()->get();
            }

            // Save all the role ids. If one of them is an admin, stop there.
            $this->roleIds = [];
            foreach ($roles as $role) {
                if ($role->is_admin) {
                    $this->roleIds = true;
                    return true;
                }
                $this->roleIds[] = $role->id;
            }
        }

        return $this->roleIds;
    }
}
