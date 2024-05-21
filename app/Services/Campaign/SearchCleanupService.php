<?php

namespace App\Services\Campaign;

use Meilisearch\Client;
use App\Models\Campaign;

class SearchCleanupService
{
    /**
     * Send cleanup request
     */
    public static function cleanup(Campaign $campaign)
    {
        //Cleanup deleted campaign entries from meilisearch
        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));
        $client->getKeys();

        $client->index('entities')->deleteDocuments(['filter' => 'campaign_id = ' . $campaign->id]);
    }
}
