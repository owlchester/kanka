<?php

namespace App\Jobs;

use App\Models\CampaignRoleUser;
use App\Notifications\Header;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CampaignRoleUserJob
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public CampaignRoleUser $campaignRoleUser,
        public bool $new = true
    ) {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // If the role was deleted, don't notify anyone
        if (empty($this->campaignRoleUser) || empty($this->campaignRoleUser->campaignRole)) {
            Log::info('no role found', [$this->campaignRoleUser]);

            return;
        }

        $notification = new Header(
            'campaign.role.' . ($this->new ? 'add' : 'remove'),
            'user',
            'green',
            [
                'role' => e($this->campaignRoleUser->campaignRole->name),
                'campaign' => e($this->campaignRoleUser->campaignRole->campaign->name),
                'link' => route('dashboard', $this->campaignRoleUser->campaignRole->campaign),
            ]
        );

        $this->campaignRoleUser->user->notify($notification);
    }
}
