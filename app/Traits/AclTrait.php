<?php

namespace App\Traits;

use App\Facades\CampaignLocalization;
use App\Facades\UserPermission;
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

        // If one of the user's roles can read all entities of this type, there
        // is no need to check further.
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
            /** @var $permission CampaignPermission */
            // One of the permissions is a role, so we have access to all
            if (!empty($this->aclUseEntityID)) {
                $entityIds[] = $permission->entity_id;
            } else {
                $entityIds[] = $permission->entityId();
            }
        }

        // If the entityType is empty, we're trying to get all potential entities, so we need a way to load
        // all "journals" is one of our roles has the "journal_read" permission. This

        // Primary key used for the ID lookup. If one is provided by the model (for example in n-to-n
        // relations), use that one instead.
        $primaryKey = $this->getTable() . '.id';
        if (!empty($this->aclFieldName)) {
            $primaryKey = $this->aclFieldName;
        }
        return $query->whereIn($primaryKey, $entityIds);
    }

    /**
     * This is used when filtering on the entities table directly rather than the sub entity.
     * @param $query
     * @param null $user
     * @return mixed
     */
    public function scopeEntityAcl($query, $user = null)
    {
        // Use the User Permission Service to handle all of this easily.
        /** @var \App\Services\UserPermission $service */
        $service = UserPermission::user($user);

        if ($service->isCampaignOwner()) {
            return $query;
        }

        // Primary key used for the ID lookup. If one is provided by the model (for example in n-to-n
        // relations), use that one instead.
        $primaryKey = $this->getTable() . '.id';
        if (!empty($this->aclFieldName)) {
            $primaryKey = $this->aclFieldName;
        }

        //dd($service->entityIds());
        return $query
            ->select($this->getTable() . '.*')
            ->leftJoin('entities', 'entities.id', $this->getTable() . '.entity_id')
            ->where('is_private', false)
            ->where(function($subquery) use ($service, $primaryKey) {
            return $subquery
                ->whereIn('entities.id', $service->entityIds())
                ->orWhereIn('entities.type', $service->entityTypes());
        });
    }
}
