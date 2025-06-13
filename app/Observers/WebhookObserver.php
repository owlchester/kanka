<?php

namespace App\Observers;

use App\Models\Webhook;

class WebhookObserver
{
    public function created(Webhook $webhook)
    {
        auth()->user()->campaignLog($webhook->campaign_id, 'webhooks', 'created', ['id' => $webhook->id]);
    }

    public function updated(Webhook $webhook)
    {
        auth()->user()->campaignLog($webhook->campaign_id, 'webhooks', 'updated', ['id' => $webhook->id]);
    }

    public function deleted(Webhook $webhook)
    {
        auth()->user()->campaignLog($webhook->campaign_id, 'webhooks', 'deleted', ['id' => $webhook->id]);
    }
}
