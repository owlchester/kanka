<?php

namespace App\Models;

use App\Enums\FeatureStatus;
use App\Models\Concerns\HasUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $feature_id
 * @property Feature $feature
 *
 * @method static Builder<self> active()
 * @method static Builder<self> forFeature(Feature $feature)
 */
class FeatureChampion extends Model
{
    use HasUser;

    protected $fillable = [
        'feature_id',
        'user_id',
    ];

    /**
     * @return BelongsTo<Feature, $this>
     */
    public function feature(): BelongsTo
    {
        return $this->belongsTo(Feature::class);
    }

    public function scopeForFeature(Builder $query, Feature $feature): Builder
    {
        return $query->where('feature_id', $feature->id);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereHas('feature', function (Builder $q): void {
            $q->whereNotIn('status_id', [FeatureStatus::Done, FeatureStatus::Rejected]);
        });
    }
}
