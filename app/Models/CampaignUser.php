<?php

namespace App\Models;

use App\Scopes\CampaignScope;
use Illuminate\Database\Eloquent\Model;

class CampaignUser extends Model
{
    /**
     * @var string
     */
    public $table = 'campaign_user';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'campaign_id', 'role'];

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
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * Get the user's roles
     * @return $this
     */
    public function roles()
    {
        return $this->hasManyThrough('App\Models\CampaignRole', 'App\Models\CampaignRoleUser', 'user_id', 'id', 'user_id', 'campaign_role_id')
            ->where('campaign_id', $this->campaign_id);
    }

    /**
     * Determin if the user is part of an admin role
     * @return bool
     */
    public function isAdmin()
    {
        return $this->roles()->where(['is_admin' => true])->count() > 0;
    }
}
