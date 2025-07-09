<?php

namespace App\Services\Caches;

use App\Models\AppRelease;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ReleaseCacheService extends BaseCache
{
    public function latest(): Collection
    {
        if (! config('app.admin')) {
            return new Collection;
        }
        $key = 'latest_releases_v3';

        return Cache::remember($key, 24 * 3600 * 7, function () {
            $date = Carbon::now();

            return AppRelease::select('id', 'name', 'excerpt', 'link', 'category_id', 'created_at', 'published_at')
                ->whereRaw('id IN (select MAX(id) FROM releases WHERE published_at < \'' . $date . '\' AND (end_at IS NULL OR end_at > \'' . $date . '\') GROUP BY category_id)')
                // ->groupBy('category_id2')
                ->latest('published_at')
                ->get();
        });
    }

    public function clearLatest(): bool
    {
        return $this->forget('latest_releases');
    }
}
