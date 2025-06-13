<?php

namespace App\Listeners;

use App\Events\FeatureCreated;
use App\Jobs\Roadmap\DiscordFeatureJob;
use App\Jobs\Roadmap\SendFeatureEmailJob;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendFeatureNotification implements ShouldQueue
{
    public function __construct()
    {
        //
    }

    public function handle(FeatureCreated $event): void
    {
        SendFeatureEmailJob::dispatch($event->feature);
        DiscordFeatureJob::dispatch($event->feature);
    }
}
