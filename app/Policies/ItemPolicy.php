<?php

namespace App\Policies;

class ItemPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.item');
    }
}
