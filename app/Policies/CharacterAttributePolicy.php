<?php

namespace App\Policies;

use App\User;
use App\Models\CharacterAttribute;
use Illuminate\Auth\Access\HandlesAuthorization;

class CharacterAttributePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the characterAttribute.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CharacterAttribute  $characterAttribute
     * @return mixed
     */
    public function view(User $user, CharacterAttribute $characterAttribute)
    {
        return $user->campaign->id == $characterAttribute->character->campaign_id;
    }

    /**
     * Determine whether the user can create characterAttributes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->member();
    }

    /**
     * Determine whether the user can update the characterAttribute.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CharacterAttribute  $characterAttribute
     * @return mixed
     */
    public function update(User $user, CharacterAttribute $characterAttribute)
    {
        return $user->campaign->id == $characterAttribute->character->campaign_id &&
            ($user->member());
    }

    /**
     * Determine whether the user can delete the characterAttribute.
     *
     * @param  \App\User  $user
     * @param  \App\Models\CharacterAttribute  $characterAttribute
     * @return mixed
     */
    public function delete(User $user, CharacterAttribute $characterAttribute)
    {
        return $user->campaign->id == $characterAttribute->character->campaign_id &&
            ($user->member());
    }
}
