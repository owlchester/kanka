<?php

namespace App\Models;

use App\Models\Concerns\Paginatable;
use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class CampaignFollower
 * @package App\Models
 *
 * @property int $user_id
 * @property int $campaign_id
 * @property User $user
 * @property Campaign $campaign
 */
class CampaignFollower extends Pivot
{
    use Paginatable;

    /**
     * @var string
     */
    public $table = 'campaign_followers';

    protected $fillable = ['user_id', 'campaign_id'];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
