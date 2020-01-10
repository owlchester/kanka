<?php

namespace App\Models\Scopes;

use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

    /**
     * Campaigns with the most entities
     * @param $query
     * @return mixed
     */
    public function scopeTop($query)
    {
        return $query
            ->select([
                $this->getTable() . '.*',
                DB::raw("(select count(*) from entities where campaign_id = " . $this->getTable() . ".id and type not in ('tag', 'attribute_template')) as cpt")
            ])
            ->orderBy('cpt', 'desc')
            ;
    }

    /**
     * Used by the API to get models updated since a previous date
     * @param $query
     * @param $lastSync
     * @return mixed
     */
    public function scopeLastSync($query, $lastSync)
    {
        if (empty($lastSync)) {
            return $query;
        }
        return $query->where(with(new static)->getTable() . '.updated_at', '>', $lastSync);
    }

    /**
     * Campaigns with the most entities
     * @param $query
     * @return mixed
     */
    public function scopeTopMembers($query)
    {
        return $query
            ->select([
                $this->getTable() . '.*',
                DB::raw("(select count(*) from campaign_user where campaign_id = " . $this->getTable() . ".id) as cpt")
            ])
            ->orderBy('cpt', 'desc')
            ;
    }

    /**
     * Created today
     * @param $query
     * @return mixed
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', Carbon::today());
    }

    /**
     * Campaigns for the frontend
     * @param $query
     * @return mixed
     */
    public function scopeFront($query)
    {
        return $query
            ->with('boosts')
            ->where('visible_entity_count', '>', 0)
            ->orderBy('visible_entity_count', 'desc')
            ->orderBy('name', 'asc');
    }
}
