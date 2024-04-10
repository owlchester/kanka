<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Attribute
 * @package App\Models
 *
 * @property integer $id
 * @property integer $campaign_role_id
 * @property integer $user_id
 *
 * @property User $user
 * @property Campaign $campaign
 * @property CampaignRole $campaignRole
 * @property Carbon $created_at
 */
class CampaignRoleUser extends Model
{
    protected $fillable = [
        'campaign_role_id',
        'user_id',
    ];

    public function campaignRole()
    {
        return $this->belongsTo('App\Models\CampaignRole', 'campaign_role_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function recentlyCreated(): bool
    {
        return $this->created_at->diffInMinutes() <= 15;
    }
}
