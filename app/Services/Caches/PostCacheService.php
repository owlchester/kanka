<?php


namespace App\Services\Caches;


use App\Models\AppRelease;

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

        $data = AppRelease::orderBy('published_at', 'DESC')
            ->groupBy('category_id')
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
