<?php

namespace App\Models\Concerns;

trait CampaignLimit
{
    /**
     * Get the member limit for the campaign
     */
    public function memberLimit(): null|int
    {
        if ($this->boosted()) {
            return null;
        }
        return config('limits.campaigns.members');
    }

    /**
     * Get the role limit for the campaign
     */
    public function roleLimit(): null|int
    {
        if ($this->boosted()) {
            return null;
        }
        return config('limits.campaigns.roles');
    }

    /**
     * Get the quick link limit for the campaign
     */
    public function quickLinkLimit(): null|int
    {
        if ($this->boosted()) {
            return null;
        }
        return config('limits.campaigns.quick-links');
    }

    /**
     * Determine if the campaign can have more roles added to it
     */
    public function canHaveMoreRoles(): bool
    {
        $limit = $this->roleLimit();
        if (empty($limit)) {
            return true;
        }
        return $this->roles()->count() < $limit;
    }

    /**
     * Determine if the campaign can have more members added to it
     */
    public function canHaveMoreMembers(): bool
    {
        $limit = $this->memberLimit();
        if (empty($limit)) {
            return true;
        }
        return $this->members()->count() < $limit;
    }

    /**
     * Determine if the campaign can have more quick links added
     */
    public function canHaveMoreQuickLinks(): bool
    {
        $limit = $this->quickLinkLimit();
        if (empty($limit)) {
            return true;
        }
        return $this->menuLinks()->count() < $limit;
    }
}
