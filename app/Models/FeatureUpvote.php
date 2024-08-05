<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $feature_id
 * @property Feature $feature
 */
class FeatureUpvote extends Model
{
    use HasUser;

    public function feature(): BelongsTo
    {
        return $this->belongsTo(Feature::class);
    }
}
