<?php

namespace App\Policies;

use App\Facades\CampaignLocalization;
use App\Traits\AdminPolicyTrait;
use App\User;
use App\Models\Relation;
use Illuminate\Auth\Access\HandlesAuthorization;

class RelationPolicy
{
    use HandlesAuthorization;
    use AdminPolicyTrait;

    /**
     * Determine whether the user can view the relation.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Relation  $relation
     * @return bool
     */
    public function view(User $user, Relation $relation)
    {
        return true;
    }

    /**
     * Determine whether the user can create items.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        $campaign = CampaignLocalization::getCampaign();
        return $user->can('relations', $campaign);
    }

    /**
     * Determine whether the user can update the relation.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Relation  $relation
     * @return bool
     */
    public function update(User $user, Relation $relation)
    {
        if (empty($relation->owner) || empty($relation->owner->child)) {
            return false;
        }
        return $user->can('relation', $relation->owner->child);
    }

    /**
     * Determine whether the user can delete the relation.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Relation  $relation
     * @return bool
     */
    public function delete(User $user, Relation $relation)
    {
        // If the relation is empty, this call is comming from the bulk delete check
        if (empty($relation) || empty($relation->id)) {
            $campaign = CampaignLocalization::getCampaign();
            return $user->can('relations', $campaign);
        }
        if (empty($relation->owner) || empty($relation->owner->child)) {
            return false;
        }
        return $user->can('relation', $relation->owner->child);
    }
}
