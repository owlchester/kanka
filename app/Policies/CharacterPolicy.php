<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Character;

class CharacterPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.character');
    }

    public function personality(User $user, Character $entity): bool
    {
        return $entity->is_personality_visible || $user->isAdmin();
    }
}
