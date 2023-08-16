<?php

namespace App\Jobs\Campaigns\Exports;

use App\Models\Campaign;
use App\Services\Campaign\Exports\ExportService;
use App\Services\EntityService;
use App\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Entities implements ShouldQueue
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
            return 0;
        }

        /** @var User|null $user */
        $user = User::find($this->userId);
        if (!$user) {
            return 0;
        }

        /** @var ExportService $service */
        $service = app()->make(ExportService::class);
        $service
            ->user($user)
            ->campaign($campaign)
            ->export();

        // Don't delete in "sync" mode as there is no delay.
        $queue = config('queue.default');
        if ($queue !== 'sync') {
            EntitiesCleanup::dispatch($service->exportPath())->delay(now()->addMinutes(60));
        }

        return 1;
    }

    /**
     *
     */
    public function failed(Exception $exception)
    {
        // Set the campaign export date to null so that the user can try again.
        // If it failed once, trying again won't help, but this might motivate
        // them to report the error.
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
            ->user($user)
            ->campaign($campaign)
            ->fail();

        // Sentry will handle the rest
    }
}
