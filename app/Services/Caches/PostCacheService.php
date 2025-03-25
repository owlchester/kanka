<?php

namespace App\Services\Caches;

use App\Models\AppRelease;
use Carbon\Carbon;

class PostCacheService extends BaseCache
{
    public function latest()
    {
        if (! config('app.admin')) {
            return [];
        }
        $key = 'latest_releases_v3';
        if ($this->has($key)) {
            return $this->get($key);
        }

        $date = Carbon::now();
        $data = AppRelease::select('id', 'name', 'excerpt', 'link', 'category_id', 'created_at', 'published_at')
            ->whereRaw('id IN (select MAX(id) FROM releases WHERE published_at < \'' . $date . '\' AND (end_at IS NULL OR end_at > \'' . $date . '\') GROUP BY category_id)')
            // ->groupBy('category_id2')
            ->latest('published_at')
            ->get();

        $this->forever($key, $data);

        return $data;
    }

    public function clearLatest(): bool
    {
        return $this->forget('latest_releases');
    }
}
