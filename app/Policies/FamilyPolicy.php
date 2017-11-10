<?php

namespace App\Policies;

use App\User;
use App\Family;
use Illuminate\Auth\Access\HandlesAuthorization;

class FamilyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the family.
     *
     * @param  \App\User  $user
     * @param  \App\Family  $family
     * @return mixed
     */
    public function view(User $user, Family $family)
    {
        return $user->campaign->id == $family->campaign_id;
    }

    /**
     * Determine whether the user can create families.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return ($user->campaign->owner() || $user->campaign->member());
    }

    /**
     * Determine whether the user can update the family.
     *
     * @param  \App\User  $user
     * @param  \App\Family  $family
     * @return mixed
     */
    public function update(User $user, Family $family)
    {
        return $user->campaign->id == $family->campaign_id &&
            ($user->campaign->owner() || $user->campaign->member());
    }

    /**
     * Determine whether the user can delete the family.
     *
     * @param  \App\User  $user
     * @param  \App\Family  $family
     * @return mixed
     */
    public function delete(User $user, Family $family)
    {
        return $user->campaign->id == $family->campaign_id &&
            ($user->campaign->owner() || $user->campaign->member());
    }
}
