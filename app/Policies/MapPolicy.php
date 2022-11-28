<?php

namespace App\Policies;

class MapPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.map');
    }
}
