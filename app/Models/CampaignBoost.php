<?php

namespace App\Models;

use App\Models\Concerns\Paginatable;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Prunable;

/**
 * Class CampaignBoost
 * @package App\Models
 *
 * @property int $user_id
 * @property int $campaign_id
 * @property User $user
 * @property Campaign $campaign
 * @property Carbon $created_at
 */
class CampaignBoost extends Model
{
    use Paginatable;
    use Prunable;
    use SoftDeletes;

    protected $fillable = ['user_id', 'campaign_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function inCooldown(): bool
    {
        return app()->isProduction() && !$this->created_at->isBefore(Carbon::now()->subDays(7));
    }

    /**
     * Automatically prune old elements from the db
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function prunable()
    {
        return static::where('deleted_at', '<=', now()->subDays(90));
    }
}
