<?php

namespace App\Policies;

use App\Facades\UserCache;
use App\User;
use App\Models\Character;

class CharacterPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.character');
    }

    /**
     * @param User $user
     * @param Character $entity
     * @return bool
     */
    public function personality(User $user, Character $entity)
    {
        return $entity->is_personality_visible || UserCache::user($user)->admin() ;
    }

    /**
     * @param User $user
     * @param Character $entity
     * @return bool|mixed
     */
    public function organisation(User $user, Character $entity)
    {
        return  $this->update($user, $entity);
    }
}
