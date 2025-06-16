<?php

namespace App\Services\Campaign;

use App\Enums\UserAction;
use App\Notifications\Header;
use App\Services\Users\CampaignService;
use App\Traits\CampaignAware;
use App\Traits\UserAware;

class DeletionService
{
    use CampaignAware;
    use UserAware;

    public function __construct(
        protected CampaignService $campaignService,
        protected SearchCleanupService $searchCleanupService,
    ) {
    }

    public function delete(): void
    {
        $this->user->log(UserAction::campaignDelete, ['campaign' => $this->campaign->id]);
        $this->campaign->delete();

        // Todo: queue this maybe
        $this->searchCleanupService->campaign($this->campaign)->cleanup();

        // Delete boosters, so the user can use them on other campaigns.
        // If the person boosting isn't the current user, maybe we could warn them?
        $this->campaign->boosts()->delete();

        // Log for the user
        foreach ($this->campaign->users as $member) {
            $member->notify(new Header(
                'campaign.deleted',
                'trash',
                'yellow',
                [
                    'campaign' => $this->campaign->name,
                ]
            ));
        }

        $this->campaignService->user($this->user)->next();
    }
}
