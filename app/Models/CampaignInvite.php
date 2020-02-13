<?php

namespace App\Models;

/**
 * Class CampaignInvite
 * @package App\Models
 *
 * @property int $id
 * @property string $email
 * @property int $role_id
 * @property int $campaign_id
 * @property string $token
 * @property bool $is_active
 * @property string $type
 * @property int $validity
 */
class CampaignInvite extends MiscModel
{
    /**
     * @var string
     */
    public $table = 'campaign_invites';

    /**
     * @var array
     */
    protected $fillable = [
        'email',
        'role_id',
        'campaign_id',
        'created_by',
        'token',
        'is_active',
        'type',
        'validity',
    ];

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
    public function role()
    {
        return $this->belongsTo('App\Models\CampaignRole', 'role_id', 'id');
    }
}
