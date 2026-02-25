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

        // Safety net: ensure only one admin campaign per user can be prioritised at a time.
        // This guards against two-tab exploits where the controller check passes twice.
        if ($campaign->isDirty('is_prioritised') && $campaign->is_prioritised && auth()->check()) {
            $user = auth()->user();

            if (! $user->isElemental()) {
                $campaign->is_prioritised = false;

                return;
            }

            $adminCampaignIds = $user->campaignRoles()->where('is_admin', true)->pluck('campaign_id');
            $alreadyPrioritised = Campaign::where('is_prioritised', true)
                ->where('id', '!=', $campaign->id)
                ->whereIn('id', $adminCampaignIds)
                ->exists();

            if ($alreadyPrioritised) {
                $campaign->is_prioritised = false;
            }
        }
    }

    public function creating(Campaign $campaign)
    {
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
