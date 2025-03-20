<?php

namespace App\Console\Commands\Campaigns;

use App\Enums\CampaignImportStatus;
use App\Jobs\Campaigns\Import;
use App\Models\Campaign;
use App\Models\CampaignImport;
use Illuminate\Console\Command;

class ImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaigns:import {campaign}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-run an import job';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $campaignID = $this->argument('campaign');
        $campaign = Campaign::find($campaignID);

        $job = CampaignImport::where('campaign_id', $campaign->id)->orderBy('created_at', 'DESC')->
        where('status_id', '<>', 1)->first();
        if (! $job) {
            $this->info('No job for campaign ' . $campaign->id);

            return;
        }

        $job->status_id = CampaignImportStatus::QUEUED;
        $job->saveQuietly();

        Import::dispatch($job);
        $this->info('Re-queued campaign ' . $campaign->id);
    }
}
