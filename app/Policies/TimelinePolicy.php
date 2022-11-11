<?php

namespace App\Policies;

class TimelinePolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.timeline');
    }
}
