<?php

namespace App\Jobs\Campaigns;

use App\Enums\CampaignImportStatus;
use App\Models\CampaignImport;
use App\Services\Campaign\Import\ImportService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class Import implements ShouldQueue
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

    protected int $jobID;

    /**
     * CampaignExport constructor.
     */
    public function __construct(CampaignImport $campaignImport)
    {
        $this->jobID = $campaignImport->id;
    }

    /**
     * Execute the job
     *
     * @throws Exception
     */
    public function handle()
    {
        Log::info('Campaign import', ['init', 'id' => $this->jobID]);
        /** @var CampaignImport $job */
        $job = CampaignImport::find($this->jobID);
        if (! $job) {
            Log::info('Campaign import', ['empty', 'id' => $this->jobID]);

            return 0;
        }
        if (! $job->campaign || ! $job->user) {
            Log::info('Campaign import', ['empty_campaign_or_user', 'id' => $this->jobID]);

            return 0;
        }
        Log::info('Campaign import', ['running', 'id' => $this->jobID]);
        $job->update(['status_id' => CampaignImportStatus::RUNNING]);

        /** @var ImportService $service */
        $service = app()->make(ImportService::class);
        $service
            ->job($job)
            ->run();

        return 1;
    }

    public function failed(Throwable $exception)
    {
        $job = CampaignImport::find($this->jobID);
        if (! $job) {
            Log::info('Campaign import', ['empty', 'id' => $this->jobID]);

            return 0;
        }

        /** @var ImportService $service */
        $service = app()->make(ImportService::class);
        $service
            ->job($job)
            ->fail($exception);
    }
}
