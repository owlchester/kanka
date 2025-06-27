<?php

namespace App\Events;

use App\Models\AdminInvite;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdminInviteCreated
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public AdminInvite $adminInvite,
    ) {}
}
