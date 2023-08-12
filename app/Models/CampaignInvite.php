<?php

namespace App\Models;

/**
 * Class CampaignInvite
 * @package App\Models
 *
 * @property int $id
 * @property int $role_id
 * @property int $campaign_id
 * @property int $created_by
 * @property string $token
 * @property bool $is_active
 * @property int $validity
 */
class CampaignInvite extends MiscModel
{
    /**
     * @var string
     */
    public $table = 'campaign_invites';

    /** @var string[]  */
    protected $fillable = [
        'role_id',
        'campaign_id',
        'created_by',
        'token',
        'is_active',
        'validity',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id')
            ->withInvisible();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\Models\CampaignRole', 'role_id', 'id');
    }
}
