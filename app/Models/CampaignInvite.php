<?php

namespace App\Models;

use App\Models\MiscModel;

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
        return $this->belongsTo('App\Campaign', 'campaign_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\Models\CampaignRole', 'role_id', 'id');
    }
}
