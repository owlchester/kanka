<?php

namespace App\Policies;

use App\User;
use App\Models\Relation;
use Illuminate\Auth\Access\HandlesAuthorization;

class RelationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the item.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Relation  $relation
     * @return mixed
     */
    public function view(User $user, Relation $relation)
    {
        return $user->campaign->id == $relation->owner->child->campaign_id &&
            ($relation->is_private ? !$user->viewer() : true);
    }

    /**
     * Determine whether the user can create items.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->member();
    }

    /**
     * Determine whether the user can update the item.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Relation  $relation
     * @return mixed
     */
    public function update(User $user, Relation $relation)
    {
        return $user->campaign->id == $relation->owner->child->campaign_id &&
            ($user->member());
    }

    /**
     * Determine whether the user can delete the item.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Relation  $relation
     * @return mixed
     */
    public function delete(User $user, Relation $relation)
    {
        return $user->campaign->id == $relation->owner->child->campaign_id &&
            ($user->member());
    }
}
