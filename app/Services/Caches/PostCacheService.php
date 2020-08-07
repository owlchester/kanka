<?php


namespace App\Services\Caches;


use App\Models\AppRelease;

class PostCacheService extends BaseCache
{
    /**
     * @return mixed
     */
    public function latest()
    {
        $key = 'post_latest';
        if ($this->has($key)) {
            return $this->get($key);
        }

        $data = AppRelease::orderBy('published_at', 'DESC')
            ->first();

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
