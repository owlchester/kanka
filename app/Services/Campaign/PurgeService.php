<?php

namespace App\Services\Campaign;

use App\Models\Campaign;
use App\Services\ImageService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class PurgeService
{
    protected int $count = 0;
    protected bool $dry = true;

    public function real(): self
    {
        $this->dry = false;
        return $this;
    }

    public function count(): int
    {
        return $this->baseAll()
            ->count();
    }

    public function purgeEmpty(): int
    {
        $this->baseAll()
            ->chunk(500, function ($campaigns) {
                /** @var Campaign $campaign */
                foreach ($campaigns as $campaign) {
                    if (!$this->dry) {
                        ImageService::cleanup($campaign);
                        $campaign->delete();
                        Log::info('Services\Campaigns\PurgeService', ['campaign' => $campaign->id]);
                    }
                    $this->count++;
                }
            });
        return $this->count;
    }

    protected function baseAll(): Builder
    {
        return Campaign::select('campaigns.id')
            ->leftJoin('campaign_user as cu', 'cu.campaign_id', 'campaigns.id')
            ->whereNull('cu.id');
    }
}
