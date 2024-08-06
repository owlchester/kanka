<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use App\Models\Concerns\Paginatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Prunable;

/**
 * Class CampaignBoost
 * @package App\Models
 *
 * @property int $campaign_id
 * @property Campaign $campaign
 * @property Carbon $created_at
 */
class CampaignBoost extends Model
{
    use HasUser;
    use Paginatable;
    use Prunable;
    use SoftDeletes;

    protected $fillable = ['user_id', 'campaign_id'];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id');
    }

    public function inCooldown(): bool
    {
        return app()->isProduction() && !$this->created_at->isBefore(Carbon::now()->subDays(7));
    }

    /**
     * Automatically prune old elements from the db
     */
    public function prunable(): Builder
    {
        return static::where('deleted_at', '<=', now()->subDays(90));
    }
}
