<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 * @property string $token
 * @property int $created_by
 * @property int $campaign_id
 * @property Campaign $campaign
 * @property User $user
 *
 * @method static self|Builder check(int $campaignId)
 */
class AdminInvite extends Model
{
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     */
    public function scopeCheck(Builder $query, int $campaignId): Builder
    {
        return $query->where('campaign_id', $campaignId)
            ->whereNull('used_by');
    }
}
