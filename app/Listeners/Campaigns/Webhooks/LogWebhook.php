<?php

namespace App\Listeners\Campaigns\Webhooks;

use App\Events\Campaigns\Webhooks\WebhookCreated;
use App\Events\Campaigns\Webhooks\WebhookDeleted;
use App\Events\Campaigns\Webhooks\WebhookTested;
use App\Events\Campaigns\Webhooks\WebhookUpdated;
use App\Facades\UserLogger;

class LogWebhook
{
    public function handle(WebhookCreated|WebhookUpdated|WebhookDeleted|WebhookTested $event): void
    {
        $action = match (true) {
            $event instanceof WebhookCreated => 'created',
            $event instanceof WebhookUpdated => 'updated',
            $event instanceof WebhookDeleted => 'deleted',
            $event instanceof WebhookTested => 'tested',
        };

        if ($event instanceof WebhookUpdated && $event->webhook->wasChanged('status')) {
            $action = $event->webhook->status ? 'enabled' : 'disabled';
        }

        UserLogger::user($event->user)->campaign(
            $event->webhook->campaign_id,
            'webhooks',
            $action,
            [
                'id' => $event->webhook->id,
            ]
        );
    }
}
