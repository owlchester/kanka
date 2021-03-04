<?php


namespace App\Services\Caches;


use App\Models\AppRelease;
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

        $data = AppRelease::
            whereRaw('id IN (select MAX(id) FROM releases GROUP BY category_id)')
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
        return $this->forget('post_latest');
    }
}
