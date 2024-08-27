<?php

namespace App\Policies;

use App\Models\User;

class DiceRollPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.dice_roll');
    }

    public function roll(User $user, $entity)
    {
        return $this->view($user, $entity);
    }
}
