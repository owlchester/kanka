<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use App\Models\Concerns\HasCampaign;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CampaignInvite
 *
 * @property int $id
 * @property int $role_id
 * @property string $token
 * @property bool|int $is_active
 * @property int $validity
 */
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\CampaignRole, $this>
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo('App\Models\CampaignRole', 'role_id', 'id');
    }
}
