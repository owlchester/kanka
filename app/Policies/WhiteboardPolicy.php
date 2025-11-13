<?php

namespace App\Policies;

class WhiteboardPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.timeline');
    }
}
