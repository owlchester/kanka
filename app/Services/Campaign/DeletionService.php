<?php

namespace App\Services\Campaign;

use App\Enums\UserAction;
use App\Notifications\Header;
use App\Services\Users\CampaignService;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Support\Facades\Storage;

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

    public function cleanup(): void
    {
        // Since these are generally s3/minio storages, we need this mumbo jumbo
        $folders = ['campaign', 'campaigns', 'w'];
        foreach ($folders as $folder) {
            $path = $folder . '/' . $this->campaign->id;
            if (!Storage::directoryExists($path)) {
                continue;
            }
            $files = Storage::allFiles($path);
            if (!empty($files)) {
                Storage::delete($files);
            }
            Storage::deleteDirectory($path);
        }
    }
}
