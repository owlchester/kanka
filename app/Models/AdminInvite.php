<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $token
 * @property int $campaign_id
 * @property int $created_by
 * @property Campaign $campaign
 *
 * @method static self|Builder check(int $campaignId)
 */
class AdminInvite extends Model
{
    use HasUser;

    public string $userField = 'created_by';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Campaign, $this>
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function scopeCheck(Builder $query, int $campaignId): Builder
    {
        return $query->where('campaign_id', $campaignId)
            ->whereNull('used_by');
    }
}
