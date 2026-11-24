<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use App\Models\Concerns\Paginatable;
use App\Observers\CampaignFollowerObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class CampaignFollower
 *
 * @property int $campaign_id
 * @property Campaign $campaign
 */
#[ObservedBy(CampaignFollowerObserver::class)]
class CampaignFollower extends Pivot
{
    use HasUser;
    use Paginatable;

    /**
     * @var string
     */
    public $table = 'campaign_followers';

    protected $fillable = ['user_id', 'campaign_id'];

    /**
     * @return BelongsTo<Campaign, $this>
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id');
    }
}
