<?php

namespace App\Jobs;

use App\Models\CampaignRoleUser;
use App\Notifications\Header;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CampaignRoleUserJob implements ShouldQueue
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

    /** @var int Campaign role user id */
    public $id;

    /** @var bool if new or deleted */
    public $new;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CampaignRoleUser $campaignRoleUser, bool $new = true)
    {
        $this->id = $campaignRoleUser->id;
        $this->new = $new;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $campaignRoleUser = CampaignRoleUser::find($this->id);

        // If the role was deleted, don't notify anyone
        if (empty($campaignRoleUser) || empty($campaignRoleUser->campaignRole)) {
            return;
        }

        $notification = new Header(
            // 'campaign.role.add',
            'campaign.role.' . ($this->new ? 'add' : 'remove'),
            'user',
            'green',
            [
                'role' => e($campaignRoleUser->campaignRole->name),
                'campaign' => e($campaignRoleUser->campaignRole->campaign->name),
            ]
        );

        $campaignRoleUser->user->notify($notification);
    }
}
