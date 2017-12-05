<?php

namespace App\Policies;

use App\User;
use App\Models\Location;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the location.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Location  $location
     * @return mixed
     */
    public function view(User $user, Location $location)
    {
        return $user->campaign->id == $location->campaign_id &&
            ($location->is_private ? !$user->viewer() : true);
    }

    /**
     * Determine whether the user can create locations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->member();
    }

    /**
     * Determine whether the user can update the location.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Location  $location
     * @return mixed
     */
    public function update(User $user, Location $location)
    {
        return $user->campaign->id == $location->campaign_id &&
            ($user->member());
    }

    /**
     * Determine whether the user can delete the location.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Location  $location
     * @return mixed
     */
    public function delete(User $user, Location $location)
    {
        return $user->campaign->id == $location->campaign_id &&
            ($user->member());
    }

    /**
     * Determine if a model can be moved to another type.
     *
     * @param User $user
     * @param Location $location
     * @return mixed
     */
    public function move(User $user, Location $location)
    {
        return $this->update($user, $location);
    }
}
