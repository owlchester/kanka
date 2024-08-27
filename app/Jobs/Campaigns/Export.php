<?php

namespace App\Jobs\Campaigns;

use App\Jobs\FileCleanup;
use App\Models\Campaign;
use App\Models\CampaignExport;
use App\Services\Campaign\ExportService;
use App\Models\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class Export implements ShouldQueue
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

    protected int $campaignExportId;

    protected bool $assets;

    /**
     * CampaignExport constructor.
     */
    public function __construct(Campaign $campaign, User $user, CampaignExport $campaignExport, bool $assets = false)
    {
        $this->campaignId = $campaign->id;
        $this->userId = $user->id;
        $this->assets = $assets;
        $this->campaignExportId = $campaignExport->id;
    }

    /**
     * Execute the job
     * @throws Exception
     */
    public function handle()
    {
        Log::info('Campaign export', ['init', 'id' => $this->campaignExportId]);
        $campaignExport = CampaignExport::find($this->campaignExportId);
        if (!$campaignExport) {
            Log::info('Campaign export', ['empty', 'id' => $this->campaignExportId]);
            return 0;
        }
        Log::info('Campaign export', ['running', 'id' => $this->campaignExportId]);
        $campaignExport->update(['status' => CampaignExport::STATUS_RUNNING]);

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
            ->assets($this->assets)
            ->log($campaignExport)
            ->export();

        // Don't delete in "sync" mode as there is no delay.
        $queue = config('queue.default');
        if ($queue !== 'sync') {
            FileCleanup::dispatch($service->exportPath())->delay(now()->addDay());
        }
        return 1;
    }

    /**
     *
     */
    public function failed(Throwable $exception)
    {
        $campaignExport = CampaignExport::find($this->campaignExportId);
        if (!$campaignExport) {
            return;
        }
        $campaignExport->update(['status' => CampaignExport::STATUS_FAILED]);

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
            ->assets($this->assets)
            ->fail();

        // Sentry will handle the rest
    }
}
