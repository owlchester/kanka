<?php

namespace App\Models\Scopes;

use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

/**
 * Trait CampaignScopes
 * @package App\Models\Scopes
 *
 * @method static self|Builder visibility(int $visibility)
 * @method static self|Builder admin()
 * @method static self|Builder public()
 * @method static self|Builder top()
 * @method static self|Builder front()
 * @method static self|Builder featured(bool $featured = true)
 * @method static self|Builder filterPublic(array $filters)
 * @method static self|Builder open()
 * @method static self|Builder unboosted()
 */
trait CampaignScopes
{
    /**
     * @param $query
     * @param int $visibility
     * @return mixed
     */
    public function scopeVisibility(Builder $query, int $visibility): Builder
    {
        return $query->where($this->getTable() . '.visibility_id', $visibility);
    }

    /**
     * @param Builder $query
     * @param bool $open
     * @return Builder
     */
    public function scopeOpen(Builder $query, bool $open = true): Builder
    {
        return $query->where('is_open', $open);
    }

    /**
     * Admin crud datagrid
     * @param $query
     * @return mixed
     */
    public function scopeAdmin(Builder $query): Builder
    {
        return $query->with('users');
    }

    /**
     * Featured Campaigns
     * @param $query
     * @return mixed
     */
    public function scopeFeatured(Builder $query, $featured = true): Builder
    {
        if ($featured) {
            return $query->where('is_featured', true)
                ->where(function ($sub) {
                    return $sub->whereNull('featured_until')
                        ->orWhereDate('featured_until', '>=', Carbon::today()->toDateString());
                });
        }
        // Not featured, or featured in the past
        return $query->where('is_featured', $featured)
            ->orWhere(function ($sub) {
                return $sub->where('is_featured', true)
                    ->whereDate('featured_until', '<', Carbon::today()->toDateString());
            });
    }

    /**
     * Public campaigns
     * @param Builder|Campaign $query
     * @return mixed
     */
    public function scopePublic(Builder $query): Builder
    {
        return $query->visibility(Campaign::VISIBILITY_PUBLIC);
    }

    /**
     * Campaigns for the frontend
     * @param $query
     * @return mixed
     */
    public function scopeFront(Builder $query, string $sort = null): Builder
    {
        if (!app()->environment('local')) {
            $query
                ->where('visible_entity_count', '>', 0);
        }
        $defaultsort = $sort == 1 ? 'follower' : 'visible_entity_count';
        $query
            ->orderBy($defaultsort, 'desc')
            ->orderBy('name');

        return $query;
    }

    /**
     * @param Builder|Campaign $query
     * @param array $options
     * @return Builder
     */
    public function scopeFilterPublic(Builder $query, array $options): Builder
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
            $query->open();
        } elseif ($open === '0') {
            $query->open(false);
        }

        return $query;
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopePreparedWith($query)
    {
        return $query;
    }

    /**
     * Unboosted campaigns
     * @param Builder $query
     * @return Builder
     */
    public function scopeUnboosted(Builder $query): Builder
    {
        return $query->where(function ($sub) {
            return $sub->where('boost_count', 0)
                ->orWhereNull('boost_count');
        });
    }
}
