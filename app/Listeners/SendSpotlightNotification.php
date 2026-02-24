<?php

namespace App\Listeners;

use App\Events\SpotlightSubmitted;
use App\Jobs\Spotlight\DiscordSpotlightJob;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSpotlightNotification implements ShouldQueue
{
    public function __construct()
    {
        //
    }

    public function handle(SpotlightSubmitted $event): void
    {
        DiscordSpotlightJob::dispatch($event->spotlightContent);
    }
}
