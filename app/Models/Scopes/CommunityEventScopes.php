<?php

namespace App\Models\Scopes;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait CommunityVoteScopes
 * @package App\Models\Scopes
 *
 * @method self|Builder ongoing()
 * @method self|Builder finished()
 * @method self recent()
 * @method self visible()
 *
 */
trait CommunityEventScopes
{
    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeOngoing(Builder $builder)
    {
        return $builder
            ->where('end_at', '>=', Carbon::now())
            ->where('start_at', '<=', Carbon::now());
    }

    /**
     * @param Builder $builder
     */
    public function scopeFinished(Builder $builder)
    {
        return $builder->where('end_at', '<=', Carbon::now());
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
