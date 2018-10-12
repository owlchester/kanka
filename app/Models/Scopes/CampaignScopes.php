<?php

namespace App\Models\Scopes;

use App\Models\Campaign;

trait CampaignScopes
{
    /**
     * @param $query
     * @param $visibility
     * @return mixed
     */
    public function scopeVisibility($query, $visibility)
    {
        return $query->where('visibility', $visibility);
    }

    /**
     * Admin crud datagrid
     * @param $query
     * @return mixed
     */
    public function scopeAdmin($query)
    {
        return $query->visibility(Campaign::VISIBILITY_REVIEW);
    }

    /**
     * Featured Campaigns
     * @param $query
     * @return mixed
     */
    public function scopeFeatured($query, $featured = true)
    {
        return $query->where('is_featured', $featured);
    }

    /**
     * Public campaigns
     * @param $query
     * @return mixed
     */
    public function scopePublic($query)
    {
        return $query->visibility(Campaign::VISIBILITY_PUBLIC);
    }
}