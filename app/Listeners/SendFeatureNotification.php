<?php

namespace App\Listeners;

use App\Events\FeatureCreated;
use App\Jobs\Roadmap\DiscordFeatureJob;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendFeatureNotification implements ShouldQueue
{
    public function __construct()
    {
        //
    }

    public function handle(FeatureCreated $event): void
    {
        DiscordFeatureJob::dispatch($event->feature);
    }
}
