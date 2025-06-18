<?php

namespace App\Observers;

use App\Events\Campaigns\Deleted;
use App\Events\Campaigns\Saved;
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

        if (request()->has('is_public')) {
            $previousVisibility = $campaign->getOriginal('visibility_id');
            $isPublic = request()->get('is_public', null);
            if (! empty($isPublic) && $previousVisibility == Campaign::VISIBILITY_PRIVATE) {
                $campaign->visibility_id = Campaign::VISIBILITY_PUBLIC;
                // Default to public for now. Later will have REVIEW mode.
            } elseif (empty($isPublic) && $previousVisibility != Campaign::VISIBILITY_PRIVATE) {
                $campaign->visibility_id = Campaign::VISIBILITY_PRIVATE;
            }
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
        Saved::dispatch($campaign);
    }

    public function deleted(Campaign $campaign)
    {
        Deleted::dispatch($campaign, auth()->user());
    }
}
