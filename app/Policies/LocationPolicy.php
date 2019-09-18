<?php

namespace App\Policies;

use App\User;
use App\Models\Location;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationPolicy extends MiscPolicy
{
    protected $model = 'location';

    /**
     * Determine if a user can interact with the location's map
     * @param User $user
     * @param Location $location
     * @return bool
     */
    public function map(User $user, Location $location)
    {
        // New location? All good.
        if (empty($location)) {
            return true;
        }

        // Otherwise, either the map isn't private, or the user is an admin
        return $location->is_map_private == false || $user->isAdmin();
    }
}
