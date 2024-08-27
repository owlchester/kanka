<?php

namespace App\Policies;

use App\Facades\UserCache;
use App\Models\User;
use App\Models\Character;

class CharacterPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.character');
    }

    /**
     * @return bool
     */
    public function personality(User $user, Character $entity)
    {
        return $entity->is_personality_visible || UserCache::user($user)->admin();
    }

    /**
     * @return bool|mixed
     */
    public function organisation(User $user, Character $entity)
    {
        return  $this->update($user, $entity);
    }


    /**
     * @return bool|mixed
     */
    public function raceManagement(User $user, Character $entity)
    {
        return UserCache::user($user)->admin();
    }

    /**
     * @return bool|mixed
     */
    public function familyManagement(User $user, Character $entity)
    {
        return UserCache::user($user)->admin();
    }
}
