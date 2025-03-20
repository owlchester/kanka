<?php

namespace App\Services\Campaign;

use App\Models\Campaign;
use App\Models\JobLog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class PurgeService
{
    protected int $count = 0;

    protected bool $dry = true;

    protected array $ids = [];

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
            ->chunkById(500, function ($campaigns) {
                /** @var Campaign $campaign */
                foreach ($campaigns as $campaign) {
                    if (! $this->dry) {
                        $campaign->forceDelete();
                        Log::info('Services\Campaigns\PurgeService', ['campaign' => $campaign->id]);
                    }
                    $this->count++;
                }
            });

        return $this->count;
    }

    public function purgeDeleted(): int
    {
        $delay = Carbon::now()->subHours(config('purge.hard_delete'))->toDateString();

        Campaign::onlyTrashed()
            ->where('deleted_at', '<=', $delay)
            ->chunkById(500, function ($campaigns) {
                /** @var Campaign $campaign */
                foreach ($campaigns as $campaign) {
                    $this->ids[] = $campaign->id;
                    $campaign->forceDelete();
                    Log::info('Services\Campaigns\PurgeService', ['campaign' => $campaign->id]);
                    $this->count++;
                }
            });

        JobLog::create([
            'name' => 'cleanup:trashed-campaigns',
            'result' => implode('<br />', $this->ids),
        ]);

        return $this->count;
    }

    protected function baseAll(): Builder
    {
        return Campaign::select('campaigns.id')
            ->leftJoin('campaign_user as cu', 'cu.campaign_id', 'campaigns.id')
            ->whereNull('cu.id');
    }
}
