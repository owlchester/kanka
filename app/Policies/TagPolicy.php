<?php

namespace App\Policies;

class TagPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.tag');
    }
}
