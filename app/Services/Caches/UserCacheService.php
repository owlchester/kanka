<?php

namespace App\Services\Caches;

use App\Models\Campaign;
use App\Models\CampaignRole;
use App\Services\Caches\Traits\PrimaryCache;
use App\Services\Caches\Traits\User\CampaignCache;
use App\Services\Caches\Traits\User\RoleCache;
use App\Services\Caches\Traits\User\TutorialCache;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserCacheService extends BaseCache
{
    use CampaignAware;
    use CampaignCache;
    use PrimaryCache;
    use RoleCache;
    use TutorialCache;
    use UserAware;

    public function user(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function __construct()
    {
        // Move this to cache service provider?
        if (auth()->check()) {
            $this->user(auth()->user());
        }
    }

    /**
     * Get the username
     * @param int $userId the user id
     */
    public function name(int $userId): string
    {
        $key = $this->nameKey($userId);
        if ($this->has($key)) {
            return (string) $this->get($key);
        }

        /** @var ?User $user */
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
     */
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
            'boosted' => $campaign->boosted()
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

    protected function primaryKey(): string
    {
        return 'user_' . $this->user->id;
    }
}
