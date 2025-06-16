<?php

namespace App\Services\Campaign;

use App\Traits\CampaignAware;
use Meilisearch\Client;

class SearchCleanupService
{
    use CampaignAware;

    /**
     * Send cleanup request
     */
    public function cleanup()
    {
        // Cleanup deleted campaign entries from meilisearch
        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));
        $client->getKeys();

        $client->index('entities')->deleteDocuments(['filter' => 'campaign_id = ' . $this->campaign->id]);
    }
}
