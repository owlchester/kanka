<?php

namespace App\Services\Caches;

use App\Models\Campaign;
use App\Models\CampaignRole;
use App\Models\User;
use App\Models\UserFlag;
use App\Services\Caches\Traits\PrimaryCache;
use App\Services\Caches\Traits\User\CampaignCache;
use App\Services\Caches\Traits\User\RoleCache;
use App\Services\Caches\Traits\User\TutorialCache;
use App\Services\Caches\Traits\User\UserFlagCache;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UserCacheService extends BaseCache
{
    use CampaignAware;
    use CampaignCache;
    use PrimaryCache;
    use UserFlagCache;
    use RoleCache;
    use TutorialCache;
    use UserAware;

    /**
     * Get the username
     *
     * @param  int  $userId  the user id
     */
    public function name(int $userId): string
    {
        $key = $this->nameKey($userId);

        return Cache::remember($key, 3600 * 24, function () use ($userId) {
            /** @var ?User $user */
            $user = User::select('name')->find($userId);

            return $user?->name;
        });
    }

    public function clearName(): self
    {
        $key = $this->nameKey($this->user->id);
        $this->forget($key);

        return $this;
    }

    public function entitiesCreatedCount(): int
    {
        $key = 'user_' . $this->user->id . '_entities_created_count';

        return Cache::remember($key, 24 * 3600, function () {
            return DB::table('entities')->where('created_by', $this->user->id)->count();
        });
    }

    protected function nameKey(int $userId): string
    {
        return 'user_' . $userId . '_name';
    }

    protected function primaryData(): array
    {
        // Prepare the data.
        $data = [
            'campaigns' => [],
            'follows' => [],
            'roles' => [],
            'tutorials' => [],
            'flags' => [],
        ];

        /** @var Campaign $campaign */
        foreach ($this->user->campaigns()->userOrdered($this->user)->get() as $campaign) {
            $data['campaigns'][] = $this->formatCampaign($campaign);
        }

        /** @var Campaign $campaign */
        foreach ($this->user->following()->public()->userOrdered($this->user)->get() as $campaign) {
            $data['follows'][] = $this->formatCampaign($campaign);
        }

        // Track the user's admin roles
        foreach ($this->user->campaignRoles as $role) {
            $data['roles'][$role->campaign_id][] = $this->formatRole($role);
        }

        foreach ($this->user->flags as $flag) {
            $data['flags'][$flag->flag->value] = $this->formatFlag($flag);
        }

        $data['tutorials'] = $this->prepareTutorials();

        return $data;
    }

    /**
     * Format the campaign for the cache
     */
    protected function formatCampaign(Campaign $campaign): array
    {
        return [
            'id' => $campaign->id,
            'name' => $campaign->name,
            'route' => route('dashboard', $campaign),
            'image' => $campaign->image,
            'boosted' => $campaign->boosted(),
        ];
    }

    /**
     * Format the role for the cache
     */
    protected function formatRole(CampaignRole $role): array
    {
        return [
            'id' => $role->id,
            'name' => $role->name,
            'is_admin' => $role->isAdmin(),
            'is_public' => $role->isPublic(),
        ];
    }

    /**
     * Format a flag for the cache
     */
    protected function formatFlag(UserFlag $role): array
    {
        return [
            'amount' => $role->amount,
        ];
    }

    protected function primaryKey(): string
    {
        return 'user_' . $this->user->id;
    }
}
