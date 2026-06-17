<?php

namespace App\Listeners\Users\Subscriptions;

use App\Events\Subscriptions\AutoRemove;
use App\Events\Subscriptions\Boost;
use App\Events\Subscriptions\Disable;
use App\Events\Subscriptions\Premium;
use App\Events\Subscriptions\SuperBoost;
use App\Events\Subscriptions\Upgrade;
use App\Facades\UserLogger;

class LogPremium
{
    public function handle(Boost|SuperBoost|Upgrade|Premium|AutoRemove|Disable $event): void
    {
        $action = match (true) {
            $event instanceof Boost => 'boosted',
            $event instanceof SuperBoost => 'superboosted',
            $event instanceof Upgrade => 'upgraded',
            $event instanceof Premium => 'premium',
            $event instanceof AutoRemove => 'auto-removed',
            $event instanceof Disable => 'disabled',
        };

        UserLogger::user($event->user)->campaign(
            $event->campaign->id,
            'premium',
            $action
        );
    }
}
