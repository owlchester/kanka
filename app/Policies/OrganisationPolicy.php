<?php

namespace App\Policies;

use App\User;
use App\Organisation;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganisationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the organisation.
     *
     * @param  \App\User  $user
     * @param  \App\Organisation  $organisation
     * @return mixed
     */
    public function view(User $user, Organisation $organisation)
    {
        return $user->campaign->id == $organisation->campaign_id;
    }

    /**
     * Determine whether the user can create organisations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->campaign->owner() || $user->campaign->member();
    }

    /**
     * Determine whether the user can update the organisation.
     *
     * @param  \App\User  $user
     * @param  \App\Organisation  $organisation
     * @return mixed
     */
    public function update(User $user, Organisation $organisation)
    {
        return $user->campaign->id == $organisation->campaign_id &&
            ($user->campaign->owner() || $user->campaign->member());
    }

    /**
     * Determine whether the user can delete the organisation.
     *
     * @param  \App\User  $user
     * @param  \App\Organisation  $organisation
     * @return mixed
     */
    public function delete(User $user, Organisation $organisation)
    {
        return $user->campaign->id == $organisation->campaign_id &&
            ($user->campaign->owner() || $user->campaign->member());
    }
}
