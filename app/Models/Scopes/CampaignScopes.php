<?php

namespace App\Models\Scopes;

use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * Trait CampaignScopes
 * @package App\Models\Scopes
 *
 * @method static self|Builder visibility(int $visibility)
 * @method static self|Builder admin()
 * @method static self|Builder public()
 * @method static self|Builder top()
 * @method static self|Builder front()
 * @method static self|Builder featured(bool $features = true)
 * @method static self|Builder filterPublic(array $filters)
 * @method static self|Builder open()
 */
trait CampaignScopes
{
    /**
     * @param $query
     * @param int $visibility
     * @return mixed
     */
    public function scopeVisibility(Builder $query, int $visibility)
    {
        return $query->where($this->getTable() . '.visibility_id', $visibility);
    }

    /**
     * @param $query
     * @param $visibility
     * @return mixed
     */
    public function scopeOpen(Builder $query)
    {
        return $query->where('is_open', true);
    }

    /**
     * Admin crud datagrid
     * @param $query
     * @return mixed
     */
    public function scopeAdmin(Builder $query)
    {
        return $query->with('users');
    }

    /**
     * Featured Campaigns
     * @param $query
     * @return mixed
     */
    public function scopeFeatured(Builder $query, $featured = true)
    {
        return $query->where('is_featured', $featured)
            ->where(function ($sub) {
                return $sub->whereNull('featured_until')
                    ->orWhereDate('featured_until', '>=', Carbon::today()->toDateString());
            });
    }

    /**
     * Public campaigns
     * @param $query
     * @return mixed
     */
    public function scopePublic(Builder $query)
    {
        return $query->visibility(Campaign::VISIBILITY_PUBLIC);
    }

    /**
     * Campaigns with the most entities
     * @param $query
     * @return mixed
     */
    public function scopeTop(Builder $query)
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
     * Campaigns with the most entities
     * @param $query
     * @return mixed
     */
    public function scopeTopMembers(Builder $query)
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
    public function scopeToday(Builder $query)
    {
        return $query->whereDate('created_at', Carbon::today());
    }

    /**
     * Campaigns for the frontend
     * @param $query
     * @return mixed
     */
    public function scopeFront(Builder $query)
    {
        return $query
            ->where('visible_entity_count', '>', 0)
            ->orderBy('visible_entity_count', 'desc')
            ->orderBy('name', 'asc');
    }

    public function scopeFilterPublic(Builder $query, array $options)
    {
        $language = Arr::get($options, 'language');
        $system = Arr::get($options, 'system');
        if (!empty($language)) {
            $query->where('locale', $language);
        }
        if (!empty($system)) {
            $valid =  \App\Facades\CampaignCache::systems();
            if ($system == 'other') {
                $query->whereNotIn('system', $valid);
            } elseif (in_array($system, $valid)) {
                $query->where('system', $system);
            }
        }
        $boosted = Arr::get($options, 'is_boosted');
        if ($boosted === "1") {
            $query->where('boost_count', '>=', 1);
        } elseif ($boosted === "0") {
            $query->where(function($sub) { return $sub->where('boost_count', 0)->orWhereNull('boost_count'); });
        }

        $open = Arr::get($options, 'is_open');
        if ($open === '1') {
            $query->where('is_open', true);
        } elseif ($open === '0') {
            $query->where('is_open', false);
        }

        return $query;
    }
}
