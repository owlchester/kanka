<?php

namespace App\Services\Caches;

use App\Services\Caches\Traits\User\CampaignCache;
use App\Services\Caches\Traits\User\RoleCache;
use App\User;
use Illuminate\Support\Facades\DB;

class UserCacheService extends BaseCache
{
    use CampaignCache;
    use RoleCache;

    /**
     * Get the username
     * @param int $userId the user id
     * @return string
     */
    public function name(int $userId): string
    {
        $key = $this->nameKey($userId);
        if ($this->has($key)) {
            return (string) $this->get($key);
        }

        /** @var User|null $user */
        $user = User::select('name')->find($userId);
        $data = $user?->name;

        $this->forever($key, $data);

        return $data;
    }

    /**
     * @return $this
     */
    public function clearName(): self
    {
        $key = $this->nameKey($this->user->id);
        $this->forget($key);
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
     * @return string
     */
    protected function nameKey(int $userId): string
    {
        return 'user_' . $userId . '_name';
    }
}
