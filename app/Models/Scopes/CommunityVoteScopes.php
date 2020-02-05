<?php
/**
 * Description of
 *
 * @author Jeremy Payne it@watson.ch
 * 05/02/2020
 */

namespace App\Models\Scopes;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait CommunityVoteScopes
{
    /**
     * @param Builder $builder
     */
    public function scopePublished(Builder $builder)
    {
        return $builder->where('published_at', '>=', Carbon::now());
    }

    /**
     * @param Builder $builder
     */
    public function scopeVoting(Builder $builder)
    {
        return $builder
            ->where('visible_at', '<=', Carbon::now())
            ->where('published_at', '>=', Carbon::now());
    }
}
