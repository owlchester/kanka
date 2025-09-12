<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Whiteboard;

class WhiteboardPolicy
{
    public function view(?User $user, Whiteboard $whiteboard): bool
    {
        return true;
    }
}
