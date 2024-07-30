<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use App\Models\Concerns\HasCampaign;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CampaignInvite
 * @package App\Models
 *
 * @property int $id
 * @property int $role_id
 * @property int|null $created_by
 * @property string $token
 * @property bool|int $is_active
 * @property int $validity
 */
class CampaignInvite extends MiscModel
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

    public function role(): BelongsTo
    {
        return $this->belongsTo('App\Models\CampaignRole', 'role_id', 'id');
    }
}
