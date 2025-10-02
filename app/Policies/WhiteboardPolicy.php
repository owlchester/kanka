<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Whiteboard;

class WhiteboardPolicy extends MiscPolicy
{
    public function entityTypeID(): int
    {
        return config('entities.ids.timeline');
    }
}
