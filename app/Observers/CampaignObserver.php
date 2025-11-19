<?php

namespace App\Observers;

use App\Events\Campaigns\Deleted;
use App\Events\Campaigns\Saved;
use App\Events\Campaigns\Updated;
use App\Models\Campaign;
use App\Services\Mentions\SaveService;

class CampaignObserver
{
    use PurifiableTrait;

    public function __construct(protected SaveService $saveService) {}

    public function saving(Campaign $campaign)
    {
        // Purity text
        $attributes = $campaign->getAttributes();
        if (array_key_exists('excerpt', $attributes)) {
            $campaign->excerpt = $this->purify(
                $this->saveService
                    ->campaign($campaign)
                    ->user(auth()->user())
                    ->text($campaign->excerpt)
                    ->save()
            );
        }
    }

    public function creating(Campaign $campaign)
    {
        // $campaign->is_featured = false;
        $campaign->entity_visibility = false;
        $campaign->entity_personality_visibility = false;
        $campaign->follower = 0;
    }

    public function saved(Campaign $campaign)
    {
        Saved::dispatch($campaign, auth()->user());
    }

    public function updated(Campaign $campaign)
    {
        Updated::dispatch($campaign, auth()->user());
    }

    public function deleted(Campaign $campaign)
    {
        Deleted::dispatch($campaign, auth()->user());
    }
}
