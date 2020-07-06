<?php

namespace App\Models;

use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\Model;
use DateTime;

/**
 * Class Attribute
 * @package App\Models
 *
 * @property integer $id
 * @property integer $campaign_role_id
 * @property integer $user_id
 */
class CampaignRoleUser extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'campaign_role_id',
        'user_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function campaignRole()
    {
        return $this->belongsTo('App\Models\CampaignRole', 'campaign_role_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
