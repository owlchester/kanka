<?php

namespace App\Jobs\Campaigns\Exports;

use App\Models\Campaign;
use App\Notifications\Header;
use App\Services\Campaign\Exports\ExportService;
use App\Services\EntityService;
use App\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Asset implements ShouldQueue
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

    protected int $campaignId;

    protected int $userId;

    protected EntityService $entity;

    /**
     * CampaignExport constructor.
     * @param Campaign $campaign
     * @param User $user
     */
    public function __construct(Campaign $campaign, User $user)
    {
        $this->campaignId = $campaign->id;
        $this->userId = $user->id;
    }

    /**
     * Execute the job
     * @throws Exception
     */
    public function handle()
    {
        /** @var Campaign|null $campaign */
        $campaign = Campaign::find($this->campaignId);
        if (!$campaign) {
            return;
        }

        /** @var User|null $user */
        $user = User::find($this->userId);
        if (!$user) {
            return;
        }

        /** @var ExportService $service */
        $service = app()->make(ExportService::class);
        $service
            ->campaign($campaign)
            ->user($user)
            ->assets()
            ->export();

        // Don't delete in "sync" mode as there is no delay.
        $queue = config('queue.default');
        if ($queue != 'sync') {
            AssetCleanup::dispatch($service->exportPath())->delay(now()->addMinutes(60));
        }
    }

    /**
     *
     */
    public function failed(Exception $exception)
    {
        // Notify the user that something went wrong
        $this->user->notify(new Header(
            'campaign.asset_export_error',
            'times',
            'red'
        ));
    }
}
