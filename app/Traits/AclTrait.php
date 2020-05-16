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
     * Set to false on the model if the model doesn't have an is_private field (ie entity_events)
     * @var bool
     */
    public $aclIsPrivate = true;

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
        $query = $query
            ->select($this->getTable() . '.*')
            ->leftJoin('entities', 'entities.id', $this->getTable() . '.entity_id')
            ->where(function ($subquery) use ($service, $primaryKey) {
                return $subquery
                    ->whereIn('entities.id', $service->entityIds())
                    ->orWhereIn('entities.type', $service->entityTypes());
            });

        if ($this->aclIsPrivate) {
            $query = $query->where('is_private', false);
        }

        return $query;
    }
}
