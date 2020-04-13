<?php

namespace App\Models\Scopes;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait CommunityVoteScopes
 * @package App\Models\Scopes
 *
 * @method self published()
 * @method self voting()
 * @method self recent()
 * @method self visible()
 */
trait CommunityVoteScopes
{
    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeVisible(Builder $builder)
    {
        return $builder
            ->where('visible_at', '<=', Carbon::now());
    }

    /**
     * @param Builder $builder
     */
    public function scopePublished(Builder $builder)
    {
        return $builder->where('published_at', '<=', Carbon::now());
    }

    /**
     * @param Builder $builder
     */
    public function scopeVoting(Builder $builder)
    {
        return $builder
            ->where('published_at', '>=', Carbon::now())
            ->visible();
    }

    /**
     * @param Builder $builder
     * @return mixed
     */
    public function scopeRecent(Builder $builder)
    {
        return $builder
            ->published()
            ->orderBy('published_at', 'DESC')
            ->take(5);
    }
}
