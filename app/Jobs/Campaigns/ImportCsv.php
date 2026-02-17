<?php

namespace App\Jobs\Campaigns;

use App\Enums\CampaignImportStatus;
use App\Models\CampaignImport;
use App\Models\EntityType;
use App\Services\CsvImportService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class ImportCsv implements ShouldQueue
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
    protected int $userId;
    protected int $entityTypeId;
    protected array $columnMap;
    protected array $tagIds;
    protected array $appearances;
    protected array $personalities;

    /**
     * CampaignExport constructor.
     */
    public function __construct(CampaignImport $campaignImport, int $userId, int $entityTypeId, array $columnMap, array $tagIds, array $appearances, array $personalities)
    {
        $this->jobID = $campaignImport->id;
        $this->userId = $userId;
        $this->columnMap = $columnMap;
        $this->tagIds = $tagIds;
        $this->entityTypeId = $entityTypeId;
        $this->appearances = $appearances;
        $this->personalities = $personalities;
    }

    /**
     * Execute the job
     *
     * @throws Exception
     */
    public function handle()
    {
        Log::info('CSV campaign import', ['init', 'id' => $this->jobID]);
        /** @var CampaignImport $job */
        $job = CampaignImport::find($this->jobID);

        $entityType = EntityType::inCampaign($job->campaign)->where('id', $this->entityTypeId)->first();

        $logs = $job->logs;
        if (! $job) {
            Log::info('CSV campaign import', ['empty', 'id' => $this->jobID]);

            return 0;
        }

        if (! $job->campaign || ! $job->user || !$entityType) {
            $logs[] = 'Missing campaign, user or entity type';

            Log::info('Campaign import', ['empty_campaign_or_user', 'id' => $this->jobID]);
            $job->update(['status_id' => CampaignImportStatus::FAILED, 'logs' => $logs]);

            return 0;
        }

        $logs[] = 'Running csv import';
        Log::info('CSV campaign import', ['running', 'id' => $this->jobID]);
        $job->update(['status_id' => CampaignImportStatus::RUNNING, 'logs' => $logs]);

        $service = app()->make(CsvImportService::class)
            ->job($job)
            ->campaign($job->campaign)
            ->user($job->user)
            ->entityType($entityType)
            ->fieldMap($this->columnMap)
            ->traits($this->appearances, $this->personalities)
            ->tags($this->tagIds)
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

        /** @var CsvImportService $service */
        $service = app()->make(CsvImportService::class);
        $service
            ->job($job)
            ->fail($exception);
    }
}
