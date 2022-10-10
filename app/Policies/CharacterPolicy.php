<?php

namespace App\Policies;

use App\User;
use App\Models\Character;

class CharacterPolicy extends MiscPolicy
{
    protected $model = 'character';

    /**
     * @param User $user
     * @param Character $entity
     * @return bool
     */
    public function personality(User $user, Character $entity)
    {
        return $entity->is_personality_visible || $user->isAdmin();
    }

    /**
     * @param User $user
     * @param Character $entity
     * @param string $subAction
     * @return bool|mixed
     */
    public function organisation(User $user, Character $entity, string $subAction = 'browse')
    {
        return  $this->update($user, $entity);
    }
}
