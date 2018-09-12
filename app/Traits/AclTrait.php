<?php

namespace App\Traits;

use App\Facades\CampaignLocalization;
use App\Models\CampaignPermission;
use App\Scopes\VisibleScope;

/**
 * Trait AclTrait
 * @package App\Traits
 *
 * Todo: Refactor for less calls on each page load. Cache results? To session? Do the logic in php?
 * Load all "item" and "items" on calls and loop through the results?
 * At least cache the roles.
 */
trait AclTrait
{
    /**
     * Scope a query to only include elements that are visible
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAcl($query, $user)
    {
        // Loop through the roles to build a list of ids, and check if one of our roles is an admin
        $roleIds = [];

        if ($user) {
            foreach ($user->campaignRoles as $role) {
                if ($role->is_admin) {
                    return $query;
                }
                $roleIds[] = $role->id;
            }
        } else {
            // Campaign public role
            $campaign = CampaignLocalization::getCampaign();
            $roleIds = $campaign->roles()->public()->pluck('id')->toArray();
        }

        // Check for a permission related to this action.
        $key = $this->entityType . '_read';
        $inRole = CampaignPermission::where(['key' => $key])
                ->whereIn('campaign_role_id', $roleIds)
                ->count() > 0;
        if ($inRole) {
            return $query;
        }

        // Specific access view to an entity for role or user
        $key = $this->entityType . '_read_';
        $entityIds = [];
        foreach (CampaignPermission::where('key', 'like', "%$key%")
                     ->where(function ($query) use ($user, $roleIds) {
                         return $query->where(['user_id' => $user->id])->orWhereIn('campaign_role_id', $roleIds);
                     })
                     ->get() as $permission) {
            // One of the permissions is a role, so we have access to all
            $entityIds[] = $permission->entityId();
        }

        return $query->whereIn($this->aclFieldName, $entityIds);
    }
}
