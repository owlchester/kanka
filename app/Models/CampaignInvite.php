<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use App\Models\Concerns\HasCampaign;
use App\Observers\CampaignInviteObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CampaignInvite
 *
 * @property int $id
 * @property int $role_id
 * @property string $token
 * @property bool $is_active
 * @property int $validity
 */
#[ObservedBy(CampaignInviteObserver::class)]
class CampaignInvite extends Model
{
    use Blameable;
    use HasCampaign;

    /**
     * @var string
     */
    public $table = 'campaign_invites';

    protected $fillable = [
        'role_id',
        'campaign_id',
        'created_by',
        'token',
        'is_active',
        'validity',
    ];

    public $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * @return BelongsTo<CampaignRole, $this>
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo('App\Models\CampaignRole', 'role_id', 'id');
    }
}
