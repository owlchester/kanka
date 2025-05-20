<?php

namespace App\Services\Caches;

use App\Models\Plugin;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MarketplaceCacheService extends BaseCache
{
    public function counts(): array
    {
        $key = $this->countKey();
        if (Cache::has($key)) {
            return Cache::get($key);
        }

        $data = [
            1 => 0,
            2 => 0,
            3 => 0,
        ];
        $bonus = config('app.debug') ? 22 : 1;
        $counts = Plugin::where('status_id', 3)
            ->groupBy('type_id')
            ->select('type_id', DB::raw('count(*) as tot'))
            ->get()
            ->toArray();
        foreach ($counts as $type) {
            $data[$type['type_id']] = $type['tot'] * $bonus;
        }

        Cache::put($key, $data, 24 * 3600);

        return $data;
    }

    public function clearCount(): self
    {
        $this->forget(
            $this->countKey()
        );

        return $this;
    }

    /**
     * Type suggestion cache key
     */
    protected function countKey(): string
    {
        return 'marketplace_counts';
    }
}
