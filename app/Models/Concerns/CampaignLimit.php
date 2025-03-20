<?php

namespace App\Models\Concerns;

trait CampaignLimit
{
    /**
     * Get the member limit for the campaign
     */
    public function memberLimit(): ?int
    {
        if ($this->boosted()) {
            return null;
        }

        return config('limits.campaigns.members');
    }

    /**
     * Get the role limit for the campaign
     */
    public function roleLimit(): ?int
    {
        if ($this->boosted()) {
            return null;
        }

        return config('limits.campaigns.roles');
    }

    /**
     * Get the quick link limit for the campaign
     */
    public function bookmarkLimit(): ?int
    {
        if ($this->boosted()) {
            return null;
        }

        return config('limits.campaigns.bookmarks');
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
    public function canHaveMoreBookmarks(): bool
    {
        $limit = $this->bookmarkLimit();
        if (empty($limit)) {
            return true;
        }

        return $this->bookmarks()->count() < $limit;
    }
}
