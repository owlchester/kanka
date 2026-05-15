<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\Relation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RelationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the relation.
     *
     * @return bool
     */
    public function view()
    {
        return true;
    }

    /**
     * Determine whether the user can create items.
     */
    public function create(User $user, Campaign $campaign): bool
    {
        return $user->can('relations', $campaign);
    }

    /**
     * Determine whether the user can update the relation.
     *
     * @return bool
     */
    public function update(User $user, Relation $relation)
    {
        if (empty($relation->owner) || $relation->owner->isMissingChild()) {
            return false;
        }

        return $user->can('relation', $relation->owner);
    }

    /**
     * Determine whether the user can delete the relation.
     */
    public function delete(User $user, ?Relation $relation, ?Campaign $campaign = null): bool
    {
        // If the relation is empty, this call is coming from the bulk delete check
        if (empty($relation) || empty($relation->id)) {
            return $campaign !== null && $user->can('relations', $campaign);
        }
        if (empty($relation->owner) || $relation->owner->isMissingChild()) {
            return false;
        }

        return $user->can('relation', $relation->owner);
    }
}
