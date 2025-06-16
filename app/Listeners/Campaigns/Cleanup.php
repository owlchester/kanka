<?php

namespace App\Listeners\Campaigns;

use App\Events\Campaigns\Deleted;
use App\Models\CampaignBoost;
use App\Notifications\Header;
use App\Services\Campaign\SearchCleanupService;
use Illuminate\Support\Facades\Storage;

class Cleanup
{
    /**
     * Create the event listener.
     */
    public function __construct(
        protected SearchCleanupService $searchCleanupService
    ) {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Deleted $event): void
    {
        $this->searchCleanupService->campaign($event->campaign)->cleanup();

        // Delete boosters, so the user can use them on other campaigns.
        $event->campaign->boosts()->delete();

        // Notify campaign members that the campaign has been deleted? But only campaigns with a single user can be deleted...
        foreach ($event->campaign->members as $member) {
            $member->user->notify(new Header(
                'campaign.deleted',
                'trash',
                'yellow',
                [
                    'campaign' => $event->campaign->name,
                ]
            ));
        }

    }
}
