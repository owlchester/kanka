<?php

namespace App\Policies;

use App\User;
use App\Models\OrganisationRelation;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganisationRelationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the characterRelation.
     *
     * @param  \App\User  $user
     * @param  \App\Models\OrganisationRelation  $characterRelation
     * @return mixed
     */
    public function view(User $user, OrganisationRelation $characterRelation)
    {
        return $user->campaign->id == $characterRelation->first->campaign_id;
    }

    /**
     * Determine whether the user can create characterRelations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->member();
    }

    /**
     * Determine whether the user can update the characterRelation.
     *
     * @param  \App\User  $user
     * @param  \App\Models\OrganisationRelation  $characterRelation
     * @return mixed
     */
    public function update(User $user, OrganisationRelation $characterRelation)
    {
        return $user->campaign->id == $characterRelation->first->campaign_id &&
            ($user->member());
    }

    /**
     * Determine whether the user can delete the characterRelation.
     *
     * @param  \App\User  $user
     * @param  \App\Models\OrganisationRelation  $characterRelation
     * @return mixed
     */
    public function delete(User $user, OrganisationRelation $characterRelation)
    {
        return $user->campaign->id == $characterRelation->first->campaign_id &&
            ($user->member());
    }
}
