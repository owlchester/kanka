<?php

namespace App\Policies;

use App\User;
use App\Character;
use Illuminate\Auth\Access\HandlesAuthorization;

class CharacterPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the character.
     *
     * @param  \App\User  $user
     * @param  \App\Character  $character
     * @return mixed
     */
    public function view(User $user, Character $character)
    {
        return $user->campaign->id == $character->campaign_id &&
            ($character->is_private ? !$user->viewer() : true);
    }

    /**
     * Determine whether the user can create characters.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->member();
    }

    /**
     * Determine whether the user can update the character.
     *
     * @param  \App\User  $user
     * @param  \App\Character  $character
     * @return mixed
     */
    public function update(User $user, Character $character)
    {
        return $user->campaign->id == $character->campaign_id &&
            ($user->member());
    }

    /**
     * Determine whether the user can delete the character.
     *
     * @param  \App\User  $user
     * @param  \App\Character  $character
     * @return mixed
     */
    public function delete(User $user, Character $character)
    {
        return $user->campaign->id == $character->campaign_id &&
            ($user->member());
    }

    public function personality(User $user, Character $character)
    {
        return ($user->member() || $character->is_personality_visible);
    }
}
