<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $status_id
 * @property int $category_id
 * @property int $created_by
 * @property int $upvote_count
 * @property User|null $user
 * @property FeatureCategory $category
 * @property FeatureStatus $status
 */
class Feature extends Model
{
    public $fillable = [
        'name',
        'description',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(FeatureCategory::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(FeatureStatus::class);
    }

    public function uservote(): HasOne
    {
        return $this->hasOne(FeatureVote::class)
            ->where('user_id', auth()->user()->id);
    }

    public function scopeApproved(Builder $builder): Builder
    {
        return $this->whereIn('status_id', [\App\Enums\FeatureStatus::Approved])
            ->orderBy('upvote_count', 'DESC');
    }
}
