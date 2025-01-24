<?php

namespace App\Policies;

class DiceRollPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.dice_roll');
    }
}
