<?php

namespace App\Policies;

use App\User;
use App\Models\LocationAttribute;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationAttributePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the locationAttribute.
     *
     * @param  \App\User  $user
     * @param  \App\Models\LocationAttribute  $locationAttribute
     * @return mixed
     */
    public function view(User $user, LocationAttribute $locationAttribute)
    {
        return $user->campaign->id == $locationAttribute->location->campaign_id;
    }

    /**
     * Determine whether the user can create locationAttributes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->member();
    }

    /**
     * Determine whether the user can update the locationAttribute.
     *
     * @param  \App\User  $user
     * @param  \App\Models\LocationAttribute  $locationAttribute
     * @return mixed
     */
    public function update(User $user, LocationAttribute $locationAttribute)
    {
        return $user->campaign->id == $locationAttribute->location->campaign_id &&
            ($user->member());
    }

    /**
     * Determine whether the user can delete the locationAttribute.
     *
     * @param  \App\User  $user
     * @param  \App\Models\LocationAttribute  $locationAttribute
     * @return mixed
     */
    public function delete(User $user, LocationAttribute $locationAttribute)
    {
        return $user->campaign->id == $locationAttribute->location->campaign_id &&
            ($user->member());
    }
}
