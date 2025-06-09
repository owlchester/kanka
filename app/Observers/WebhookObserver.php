<?php

namespace App\Observers;

use App\Models\Webhook;
use App\Services\Entity\TagService;

class WebhookObserver
{
    public function saved(Webhook $webhook)
    {
        $this->saveTags($webhook);
    }

    public function created(Webhook $webhook)
    {
        auth()->user()->campaignLog($webhook->campaign_id, 'webhooks', 'created', ['id' => $webhook->id]);
    }

    public function deleted(Webhook $webhook)
    {
        auth()->user()->campaignLog($webhook->campaign_id, 'webhooks', 'deleted', ['id' => $webhook->id]);
    }

    /**
     * Save the sections/categories
     */
    protected function saveTags(Webhook $webhook)
    {
        // HTML forms will have 'save-tags', while the api will have a tag array if they want to make changes.
        if (! request()->has('tags') && ! request()->has('save-tags')) {
            return;
        }
        $ids = request()->post('tags', []);
        if (! is_array($ids)) { // People sent weird stuff through the API
            $ids = [];
        }

        /** @var TagService $tagService */
        $tagService = app()->make(TagService::class);
        $tagService
            ->user(auth()->user())
            ->campaign($webhook->campaign)
            ->model($webhook)
            ->sync($ids);
    }
}
