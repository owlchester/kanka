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
    public function scopeAcl($query, $user = null)
    {
        // If we don't have a user passed, assume we want the current logged in user.
        if (empty($user)) {
            // If the user is logged in, good. We'll use their roles.
            if (auth()->check()) {
                $user = auth()->user();
            }
        }

        // Loop through the roles to build a list of ids, and check if one of our roles is an admin
        $roleIds = [];

        // Have a user? Get their roles in this campaign.
        if (!empty($user)) {
            foreach ($user->campaignRoles as $role) {
                if ($role->is_admin) {
                    return $query;
                }
                $roleIds[] = $role->id;
            }
        }

        // If the user has no roles in this campaign, we might be in Public mode
        // Load the public campaign
        if (empty($roleIds)) {
            // Get the campaign based on what's in the url
            $campaign = CampaignLocalization::getCampaign();

            // Go and get the Public role
            $publicRole = $campaign->roles()->where('is_public', true)->first();
            if ($publicRole) {
                $roleIds[] = $publicRole->id;
            }
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
                         if (!$user) {
                             return $query->whereIn('campaign_role_id', $roleIds);
                         }
                         return $query->where(['user_id' => $user->id])->orWhereIn('campaign_role_id', $roleIds);
                     })
                     ->get() as $permission) {
            // One of the permissions is a role, so we have access to all
            $entityIds[] = $permission->entityId();
        }

        // Primary key used for the ID lookup. If one is provided by the model (for example in n-to-n
        // relations), use that one instead.
        $primaryKey = $this->getTable() . '.id';
        if (!empty($this->aclFieldName)) {
            $primaryKey = $this->aclFieldName;
        }
        return $query->whereIn($primaryKey, $entityIds);
    }
}
