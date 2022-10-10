<?php

namespace App\Services\Caches;

use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @property \App\User $user
 */
class SingleUserCacheService
{
    protected User $user;

    /**
     * @param User $user
     * @return $this
     */
    public function user(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function entitiesCreatedCount(): int
    {
        $key = 'user_' . $this->user->id . '_entities_created_count';
        if ($this->has($key)) {
            return (int) $this->get($key);
        }

        $data = DB::table('entities')->where('created_by', $this->user->id)->count();

        $this->forever($key, $data, 1);

        return $data;
    }

    /**
     * Wrapper for the cache get method
     * @param string $key
     * @return mixed
     */
    protected function get(string $key)
    {
        return Cache::get($key);
    }

    /**
     * Wrapper for the cache forever method. Don't actually store forever as data from inactive users doesn't
     * need to be kept somewhere.
     * @param string $key
     * @param mixed $data
     * @param int $days
     * @return bool
     */
    protected function forever(string $key, $data, int $days = 7): bool
    {
        Log::info(class_basename($this), [
            'forever' => $key,
        ]);
        return Cache::put($key, $data, $days * 86400);
    }

    /**
     * Wrapper for the cache has metho
     * @param string $key
     * @return bool
     */
    protected function has(string $key): bool
    {
        return Cache::has($key);
    }
}
