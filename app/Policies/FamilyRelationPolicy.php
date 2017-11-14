<?php

namespace App\Policies;

use App\User;
use App\FamilyRelation;
use Illuminate\Auth\Access\HandlesAuthorization;

class FamilyRelationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the familyRelation.
     *
     * @param  \App\User  $user
     * @param  \App\FamilyRelation  $familyRelation
     * @return mixed
     */
    public function view(User $user, FamilyRelation $familyRelation)
    {
        return $user->campaign->id == $familyRelation->first->campaign_id;
    }

    /**
     * Determine whether the user can create familyRelations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->member();
    }

    /**
     * Determine whether the user can update the familyRelation.
     *
     * @param  \App\User  $user
     * @param  \App\FamilyRelation  $familyRelation
     * @return mixed
     */
    public function update(User $user, FamilyRelation $familyRelation)
    {
        return $user->campaign->id == $familyRelation->first->campaign_id &&
            ($user->member());
    }

    /**
     * Determine whether the user can delete the familyRelation.
     *
     * @param  \App\User  $user
     * @param  \App\FamilyRelation  $familyRelation
     * @return mixed
     */
    public function delete(User $user, FamilyRelation $familyRelation)
    {
        return $user->campaign->id == $familyRelation->first->campaign_id &&
            ($user->member());
    }
}
