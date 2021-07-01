<?php


namespace App\Services\Caches;


use App\Models\AppRelease;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PostCacheService extends BaseCache
{
    /**
     * @return Collection
     */
    public function latest()
    {
        $key = 'latest_releases';
        if ($this->has($key)) {
           return $this->get($key);
        }

        $date = Carbon::now();
        $data = AppRelease::
            whereRaw('id IN (select MAX(id) FROM releases WHERE published_at < \'' . $date . '\' AND (end_at IS NULL OR end_at > \'' . $date . '\') GROUP BY category_id)')
            //->groupBy('category_id2')
            ->latest('published_at')
            ->get();

        $this->forever($key, $data);
        return $data;
    }

    /**
     * @return bool
     */
    public function clearLatest(): bool
    {
        return $this->forget('latest_releases');
    }
}
