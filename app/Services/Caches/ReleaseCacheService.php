<?php

namespace App\Services\Caches;

use App\Models\AppRelease;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ReleaseCacheService
{
    private const string CACHE_KEY = 'latest_releases_v3';

    public function latest(): Collection
    {
        if (! config('app.admin')) {
            return new Collection;
        }

        return Cache::remember(self::CACHE_KEY, 24 * 3600 * 7, function () {
            $date = Carbon::now();

            return AppRelease::select('id', 'name', 'excerpt', 'link', 'category_id', 'created_at', 'published_at')
                ->whereRaw('id IN (select MAX(id) FROM releases WHERE published_at < ? AND (end_at IS NULL OR end_at > ?) GROUP BY category_id)', [$date, $date])
                ->latest('published_at')
                ->get();
        });
    }

    public function clearLatest(): bool
    {
        return Cache::forget(self::CACHE_KEY);
    }
}
