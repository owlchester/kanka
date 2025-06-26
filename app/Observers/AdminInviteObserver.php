<?php

namespace App\Observers;

use App\Events\AdminInviteCreated;
use App\Models\AdminInvite;

class AdminInviteObserver
{
    public function created(AdminInvite $adminInvite)
    {
        AdminInviteCreated::dispatch($adminInvite);
    }
}
