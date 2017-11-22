<?php

namespace App\Policies;

use App\User;
use App\Models\QuestLocation;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestLocationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the questLocation.
     *
     * @param  \App\User  $user
     * @param  \App\Models\QuestLocation  $questLocation
     * @return mixed
     */
    public function view(User $user, QuestLocation $questLocation)
    {
        return $user->campaign->id == $questLocation->location->campaign_id;
    }

    /**
     * Determine whether the user can create questLocations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->member();
    }

    /**
     * Determine whether the user can update the questLocation.
     *
     * @param  \App\User  $user
     * @param  \App\Models\QuestLocation  $questLocation
     * @return mixed
     */
    public function update(User $user, QuestLocation $questLocation)
    {
        return $user->campaign->id == $questLocation->location->campaign_id &&
            ($user->member());
    }

    /**
     * Determine whether the user can delete the questLocation.
     *
     * @param  \App\User  $user
     * @param  \App\Models\QuestLocation  $questLocation
     * @return mixed
     */
    public function delete(User $user, QuestLocation $questLocation)
    {
        return $user->campaign->id == $questLocation->location->campaign_id &&
            ($user->member());
    }
}
