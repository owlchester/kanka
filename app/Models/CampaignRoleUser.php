<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Attribute
 *
 * @property int $id
 * @property int $campaign_role_id
 * @property Campaign $campaign
 * @property CampaignRole $campaignRole
 * @property Carbon $created_at
 */
class CampaignRoleUser extends Model
{
    use HasUser;

    protected $fillable = [
        'campaign_role_id',
        'user_id',
    ];

    public function campaignRole(): BelongsTo
    {
        return $this->belongsTo('App\Models\CampaignRole', 'campaign_role_id', 'id');
    }

    public function recentlyCreated(): bool
    {
        return $this->created_at->diffInMinutes() <= 15;
    }
}
