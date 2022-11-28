<?php

namespace App\Policies;

class AbilityPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.ability');
    }
}
