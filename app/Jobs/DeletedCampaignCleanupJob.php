<?php

namespace App\Jobs;

use App\Models\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Meilisearch\Client;

class DeletedCampaignCleanupJob implements ShouldQueue
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

    /** @var int Campaign id */
    public $campaignId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Campaign $campaign)
    {
        $this->campaignId = $campaign->id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (empty($this->campaignId)) {
            // We dont want to delete everything.
            return;
        }

        // Delete leftover images
        if (Storage::has('/w/' . $this->campaignId)) {
            Storage::deleteDirectory('/w/' . $this->campaignId);
        }
        if (Storage::has('/campaigns/' . $this->campaignId)) {
            Storage::deleteDirectory('/campaigns/' . $this->campaignId);
        }

        // Cleanup deleted campaign entries from meilisearch
        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));
        $client->getKeys();

        $client->index('entities')->deleteDocuments(['filter' => 'campaign_id = ' . $this->campaignId]);
    }
}
