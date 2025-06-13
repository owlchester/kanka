<?php

namespace App\Services\Campaign\Webhooks;

use App\Models\Webhook;
use App\Services\Entity\TagService;
use App\Traits\CampaignAware;
use App\Traits\RequestAware;
use App\Traits\UserAware;

class SaveService
{
    use CampaignAware;
    use RequestAware;
    use UserAware;

    protected Webhook $webhook;

    public function __construct(protected TagService $tagService) {}

    public function webhook(Webhook $webhook): self
    {
        $this->webhook = $webhook;

        return $this;
    }

    public function save(): Webhook
    {
        if (! isset($this->webhook)) {
            $this->create();
        }
        $this->tags();

        return $this->webhook;
    }

    protected function create(): void
    {
        $this->webhook = new Webhook($this->request->all());
        $this->webhook->campaign_id = $this->campaign->id;
        $this->webhook->save();
    }

    protected function tags(): void
    {
        // HTML forms will have 'save-tags', while the api will have a tag array if they want to make changes.
        if (! $this->request->has('tags') && ! $this->request->has('save-tags')) {
            return;
        }
        $ids = $this->request->post('tags', []);
        if (! is_array($ids)) { // People sent weird stuff through the API
            $ids = [];
        }

        $this->tagService
            ->user($this->user)
            ->campaign($this->campaign)
            ->model($this->webhook)
            ->sync($ids);
    }
}
