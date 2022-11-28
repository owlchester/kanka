<?php

namespace App\Policies;

class CreaturePolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.creature');
    }
}
