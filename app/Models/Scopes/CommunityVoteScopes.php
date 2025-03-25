<?php

namespace App\Models\Scopes;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait CommunityVoteScopes
 *
 * @method static self|Builder published()
 * @method static self|Builder voting()
 * @method static self|Builder recent()
 * @method static self|Builder visible()
 */
trait CommunityVoteScopes
{
    public function scopeVisible(Builder $builder): Builder
    {
        return $builder
            ->where('visible_at', '<=', Carbon::now());
    }

    public function scopePublished(Builder $builder): Builder
    {
        return $builder->where('published_at', '<=', Carbon::now());
    }

    public function scopeVoting(Builder $builder): Builder
    {
        // @phpstan-ignore-next-line
        return $builder
            ->where('published_at', '>=', Carbon::now())
            ->visible();
    }

    public function scopeRecent(Builder $builder): Builder
    {
        // @phpstan-ignore-next-line
        return $builder
            ->published()
            ->orderBy('published_at', 'DESC')
            ->take(5);
    }
}
