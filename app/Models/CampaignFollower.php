<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use App\Models\Concerns\Paginatable;
use App\Observers\CampaignFollowerObserver;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class CampaignFollower
 *
 * @property int $campaign_id
 * @property Campaign $campaign
 */
class CampaignFollower extends Pivot
{
    use HasUser;
    use Paginatable;

    /**
     * @var string
     */
    public $table = 'campaign_followers';

    protected $fillable = ['user_id', 'campaign_id'];

    protected static function booted()
    {
        if (app()->runningInConsole() && !app()->runningUnitTests()) {
            return;
        }
        static::observe(CampaignFollowerObserver::class);
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id');
    }
}
