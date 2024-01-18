<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\User;

/**
 * @property int $id
 * @property int $user_id
 * @property int $feature_id
 * @property User $user
 * @property Feature $feature
 */
class FeatureUpvote extends Model
{
    public function feature(): BelongsTo
    {
        return $this->belongsTo(Feature::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
