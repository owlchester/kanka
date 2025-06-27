<?php

namespace App\Listeners\Users;

use App\Jobs\Emails\EmailChangeJob;

class SendEmailUpdate
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        EmailChangeJob::dispatch($event->user, $event->email);
    }
}
