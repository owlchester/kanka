<?php

namespace App\Services\Search;

use App\Models\CampaignUser;
use App\Traits\CampaignAware;

class CampaignSearchService
{
    use CampaignAware;

    /**
     * List of roles in a campaign
     * @param string|null $query Search term
     */
    public function roles(?string $query = null): array
    {
        return $this->campaign->roles()
            ->search($query)
            ->get(['name', 'id'])
            ->toArray();
    }

    /**
     * List of members in a campaign
     * @param string|null $query Search term
     */
    public function members(?string $query = null): array
    {
        $members = $this->campaign->members()->search($query)->get();
        $result = [];

        /** @var CampaignUser $member */
        foreach ($members as $member) {
            $result[] = [
                'id' => $member->user->id,
                'name' => $member->user->name,
                'avatar' => $member->user->hasAvatar() ? $member->user->getAvatarUrl() : null
            ];
        }

        return $result;
    }
}
