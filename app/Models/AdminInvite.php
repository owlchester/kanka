<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
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
