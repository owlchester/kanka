<?php

namespace App\Services\Caches;

use Illuminate\Support\Collection;

/**
 * Class CampaignCacheService
 * @package App\Services\Caches
 */
class CampaignCacheService extends BaseCache
{
    /**
     * Members of a campaign
     * @return Collection
     */
    public function members(): Collection
    {
        $key = $this->membersKey();
        if ($this->has($key)) {
            return $this->get($key);
        }

        $data = $this->campaign->members;

        $this->put($key, $data, 24 * 3600);
        return $data;
    }

    /**
     * Clear the members cache
     * @return $this
     */
    public function clearMembers(): self
    {
        $this->forget(
            $this->membersKey()
        );
        return $this;
    }

    /**
     * @return Collection
     */
    public function roles(): Collection
    {
        $key = $this->rolesKey();
        if ($this->has($key)) {
            return $this->get($key);
        }

        $data = $this->campaign->roles;

        $this->put($key, $data, 24 * 3600);
        return $data;
    }

    /**
     * Clear the campaign roles cache
     * @return $this
     */
    public function clearRoles(): self
    {
        $this->forget(
            $this->rolesKey()
        );
        return $this;
    }

    /**
     * Count the number of entities in a campaign. Cache if for 6 hours
     * @param string|null $type
     * @return int
     */
    public function entityCount(string $type = null): int
    {
        $key = 'campaign_' . $this->campaign->id . '_entity_count' . (!empty($type) ? "_$type" : null);
        if ($this->has($key)) {
            return $this->get($key);
        }

        $data = $this->campaign->entities()->count();

        $this->put($key, $data, 6 * 3600);
        return $data;
    }

    /**
     * Count the number of followers of a campaign. Cache if for 1 hours
     * @return int
     */
    public function followerCount(): int
    {
        $key = 'campaign_' . $this->campaign->id . '_follower_count';
        if ($this->has($key)) {
            return $this->get($key);
        }

        $data = $this->campaign->followers()->count();
        $this->put($key, $data, 1 * 3600);
        return $data;
    }

    /**
     * @return $this
     */
    public function clearFollowerCount(): self
    {
        $key = 'campaign_' . $this->campaign->id . '_follower_count';
        $this->forget(
            $key
        );
        return $this;
    }

    /**
     * Campaign members cache key
     * @return string
     */
    protected function membersKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_members';
    }

    /**
     * Campaign roles cache key
     * @return string
     */
    protected function rolesKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_roles';
    }
}
