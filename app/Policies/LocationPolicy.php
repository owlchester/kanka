<?php

namespace App\Policies;

class LocationPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.location');
    }
}
