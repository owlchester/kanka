<?php

namespace App\Models;

use App\MiscModel;

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
        'email', 'campaign_id', 'created_by', 'token', 'is_active'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo('App\Campaign', 'campaign_id', 'id');
    }
}
