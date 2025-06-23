<?php

namespace App\Observers;

use App\Events\Campaigns\Webhooks\WebhookCreated;
use App\Events\Campaigns\Webhooks\WebhookDeleted;
use App\Events\Campaigns\Webhooks\WebhookUpdated;
use App\Models\Webhook;

class WebhookObserver
{
    public function created(Webhook $webhook)
    {
        WebhookCreated::dispatch($webhook, auth()->user());
    }

    public function updated(Webhook $webhook)
    {
        WebhookUpdated::dispatch($webhook, auth()->user());
    }

    public function deleted(Webhook $webhook)
    {
        WebhookDeleted::dispatch($webhook, auth()->user());
    }
}
