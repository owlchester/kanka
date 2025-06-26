<?php

namespace App\Listeners;

use App\Events\AdminInviteCreated;
use App\Jobs\Discord\AdminInviteJob;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAdminInviteNotification implements ShouldQueue
{
    public function __construct()
    {
        //
    }

    public function handle(AdminInviteCreated $event): void
    {
        AdminInviteJob::dispatch($event->adminInvite);
    }
}
