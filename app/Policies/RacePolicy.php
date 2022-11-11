<?php

namespace App\Policies;

class RacePolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.race');
    }
}
