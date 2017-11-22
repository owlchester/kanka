<?php

namespace App\Policies;

use App\User;
use App\Models\QuestCharacter;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestCharacterPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the questCharacter.
     *
     * @param  \App\User  $user
     * @param  \App\Models\QuestCharacter  $questCharacter
     * @return mixed
     */
    public function view(User $user, QuestCharacter $questCharacter)
    {
        return $user->campaign->id == $questCharacter->character->campaign_id;
    }

    /**
     * Determine whether the user can create questCharacters.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->member();
    }

    /**
     * Determine whether the user can update the questCharacter.
     *
     * @param  \App\User  $user
     * @param  \App\Models\QuestCharacter  $questCharacter
     * @return mixed
     */
    public function update(User $user, QuestCharacter $questCharacter)
    {
        return $user->campaign->id == $questCharacter->character->campaign_id &&
            ($user->member());
    }

    /**
     * Determine whether the user can delete the questCharacter.
     *
     * @param  \App\User  $user
     * @param  \App\Models\QuestCharacter  $questCharacter
     * @return mixed
     */
    public function delete(User $user, QuestCharacter $questCharacter)
    {
        return $user->campaign->id == $questCharacter->character->campaign_id &&
            ($user->member());
    }
}
