<?php

namespace App\Models\Concerns;

use App\Models\Entity;

trait CampaignLimit
{
    /**
     * Determine if a campaign is grandfathered, aka has access to features before feature changes in
     * the summer of 2022.
     * @return bool
     */
    public function isGrandfathered(): bool
    {
        $grandfathered = config('kanka.campaigns.grandfathered');
        return $this->id <= $grandfathered;
    }

    /**
     * Get the member limit for the campaign
     * @return int|null
     */
    public function memberLimit(): null|int
    {
        if ($this->isGrandfathered() || $this->boosted()) {
            return null;
        }
        return config('kanka.campaigns.member_limit');
    }

    /**
     * Get the role limit for the campaign
     * @return int|null
     */
    public function roleLimit(): null|int
    {
        if ($this->isGrandfathered() || $this->boosted()) {
            return null;
        }
        return config('kanka.campaigns.role_limit');
    }

    /**
     * Get the quick link limit for the campaign
     * @return int|null
     */
    public function quickLinkLimit(): null|int
    {
        if ($this->isGrandfathered() || $this->boosted()) {
            return null;
        }
        return config('kanka.campaigns.quick_link_limit');
    }

    /**
     * Get the limit of entities a campaign can have
     * @return int|null
     */
    public function entityLimit(): null|int
    {
        if ($this->isGrandfathered() || $this->boosted()) {
            return null;
        }
        return config('kanka.campaigns.entity_limit');
    }

    /**
     * Determine if the campaign can have more roles added to it
     * @return bool
     */
    public function canHaveMoreRoles(): bool
    {
        $limit = $this->roleLimit();
        if (empty($limit)) {
            return true;
        }
        return $this->roles()->count() <= $limit;
    }

    /**
     * Determine if the campaign can have more members added to it
     * @return bool
     */
    public function canHaveMoreMembers(): bool
    {
        $limit = $this->memberLimit();
        if (empty($limit)) {
            return true;
        }
        return $this->members()->count() <= $limit;
    }

    /**
     * Determine if the campaign can have more quick links added
     * @return bool
     */
    public function canHaveMoreQuickLinks(): bool
    {
        $limit = $this->quickLinkLimit();
        if (empty($limit)) {
            return true;
        }
        return $this->menuLinks()->count() <= $limit;
    }

    /**
     * Determine if the campaign can have more entities added to it
     * @return bool
     */
    public function canHaveMoreEntities(): bool
    {
        $limit = $this->entityLimit();
        if (empty($limit)) {
            return true;
        }
        // We don't use $this->entities, because we need to know a campaign's total entities when copying entities
        // from one campaign to another.
        return Entity::allCampaigns()
            ->where('campaign_id', $this->id)
            ->whereNotIn('type_id', [config('entities.ids.tag')])
            ->count() <= $limit;
    }

    /**
     * Get the remaining entities a campaign can add
     * @return int
     */
    /*public function remainingAvailableEntities(): int
    {
        $limit = $this->entityLimit();
        return $limit - $this->entities()->whereNotIn('type_id', [config('entities.ids.tag')])->count();
    }*/
}
