<?php

namespace App\Traits;

use App\Facades\CampaignLocalization;
use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\Scopes\VisibleScope;

/**
 * Trait EntityAclTrait
 * @package App\Traits
 *
 * Todo: Refactor for less calls on each page load. Cache results? To session? Do the logic in php?
 * Load all "item" and "items" on calls and loop through the results?
 * At least cache the roles.
 */
trait EntityAclTrait
{
    /**
     * Scope a query to only include elements that are visible
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAcl($query, $action = 'read', $user = null)
    {
        // If we don't have a user passed, assume we want the current logged in user.
        if (empty($user)) {
            // If the user is logged in, good. We'll use their roles.
            if (auth()->check()) {
                $user = auth()->user();
            }
        }

        // Loop through the roles to build a list of ids, and check if one of our roles is an admin
        $roles = [];

        // Have a user? Get their roles in this campaign.
        if (!empty($user)) {
            foreach ($user->campaignRoles as $role) {
                /** @var CampaignRole $role */

                // If one of the role is an admin, we don't need to bother any further.
                if ($role->is_admin) {
                    return $query;
                }
                $roles[] = $role;
            }
        }

        // If the user has no roles in this campaign, we might be in Public mode
        // Load the public campaign
        if (empty($roles)) {
            // Get the campaign based on what's in the url
            $campaign = CampaignLocalization::getCampaign();

            // Go and get the Public role
            $publicRole = $campaign->roles()->where('is_public', true)->first();
            if ($publicRole) {
                $roles = $publicRole;
            }
        }

        $allowedEntities = [];
        $allowedTypes = [];

        // Loop through those roles to see what the user is given access to.
        foreach ($roles as $role) {
            /** @var CampaignPermission $permission */
            foreach ($role->permissions as $permission) {
                // If targeting a whole group
                if (empty($permission->entity_id)) {
                    $type = str_singular($permission->table_name);
                    // If the action (read, write) matches what we are trying to do
//                    dump($permission->action());
//                    dump($action);
//                    dd($type);
                    if ($permission->action() == $action && !in_array($type, $allowedTypes)) {
                        $allowedTypes[] = $type;
                    }
                } else {
                    if (!in_array($permission->entity_id, $allowedEntities)) {
                        $allowedEntities[] = $permission->entity_id;
                    }
                }
            }
        }

        // Looking for entities either of the type
        return $query
            ->where('is_private', false)
            ->where(function ($q) use ($allowedTypes, $allowedEntities) {
                return $q
                    ->whereIn('type', $allowedTypes)
                    ->orWhereIn('id', $allowedEntities);
            });
    }
}
