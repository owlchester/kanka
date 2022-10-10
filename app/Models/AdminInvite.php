<?php

namespace App\Models;

use App\Models\Concerns\Searchable;
use App\Models\Concerns\Sortable;
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
    use Sortable;
    use Searchable;

    public $sortableColumns = [
        'token',
        'created_by',
        'campaign_id'
    ];

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
     * @param Builder $query
     * @param int $campaignId
     * @return Builder
     */
    public function scopeCheck(Builder $query, int $campaignId): Builder
    {
        return $query->where('campaign_id', $campaignId)
            ->whereNull('used_by');
    }
}
