<?php

namespace App\Policies;

use App\Models\Character;
use App\Models\User;

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
