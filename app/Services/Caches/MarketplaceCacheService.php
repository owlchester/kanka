<?php

namespace App\Services\Caches;

use App\Models\Plugin;
use App\Models\TimelineElement;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MarketplaceCacheService extends BaseCache
{
    /**
     * @return array
     */
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
        $counts = Plugin::where('status_id', 3)
            ->groupBy('type_id')
            ->select('type_id', DB::raw('count(*) as tot'))
            ->get()
            ->toArray();
        foreach ($counts as $type) {
            $data[$type['type_id']] = $type['tot'];
        }

        Cache::put($key, $data, 24 * 3600);
        return $data;
    }

    /**
     * @return $this
     */
    public function clearCount(): self
    {
        $this->forget(
            $this->countKey()
        );
        return $this;
    }


    /**
     * Type suggestion cache key
     * @return string
     */
    protected function countKey(): string
    {
        return 'marketplace_counts';
    }
}
