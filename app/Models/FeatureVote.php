<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $feature_id
 * @property Feature $feature
 *
 * @method static self|Builder forFeature(Feature $feature)
 */
class FeatureVote extends Model
{
    public $table = 'feature_upvotes';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function feature(): BelongsTo
    {
        return $this->belongsTo(Feature::class);
    }

    public function scopeForFeature(Builder $query, Feature $feature): Builder
    {
        return $query->where('feature_id', $feature->id);
    }
}
