<?php

namespace App\Listeners\Campaigns\Webhooks;

use App\Events\Campaigns\Webhooks\WebhookCreated;
use App\Events\Campaigns\Webhooks\WebhookDeleted;
use App\Events\Campaigns\Webhooks\WebhookTested;
use App\Events\Campaigns\Webhooks\WebhookUpdated;

class LogWebhook
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
    public function handle(WebhookCreated|WebhookUpdated|WebhookDeleted|WebhookTested $event): void
    {
        $action = match (true) {
            $event instanceof WebhookCreated => 'created',
            $event instanceof WebhookUpdated => 'updated',
            $event instanceof WebhookDeleted => 'deleted',
        };

        if ($event instanceof WebhookUpdated && $event->webhook->wasChanged('status')) {
            $action = $event->webhook->status ? 'enabled' : 'disabled';
        }

        if ($event instanceof WebhookTested) {
            $action = 'tested';
        }

        $event->user->campaignLog(
            $event->webhook->campaign_id,
            'webhooks',
            $action,
            [
                'id' => $event->webhook->id,
            ]
        );
    }
}
