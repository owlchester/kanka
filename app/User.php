<?php

namespace App;

use App\Campaign;
use App\Facades\CampaignLocalization;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DateTime;
use Illuminate\Support\Facades\Session;

class User extends \TCG\Voyager\Models\User
{
    /**
     * Cached calculation if the user is an admin of the current campaign he is viewing
     * @var null
     */
    protected $isAdminCached = null;

    protected static $currentCampaign = false;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'last_campaign_id', 'provider', 'provider_id', 'newsletter', 'locale', 'timezone',
        'campaign_role', 'theme',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the user's campaign
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getCampaignAttribute()
    {
        // We use a dirty static system because relying on the last_campaign_id doesn't work when two sessions
        // are active form the same user.
        if (self::$currentCampaign === false) {
            self::$currentCampaign = CampaignLocalization::getCampaign();
        }
        return self::$currentCampaign;
    }

    /**
     * Last campaign the user switched to.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lastCampaign()
    {
        return $this->belongsTo(Campaign::class, 'last_campaign_id', 'id');
    }

    /**
     * Get the user's campaign
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dashboardSetting()
    {
        return $this->hasOne('App\Models\UserDashboardSetting', 'user_id', 'id');
    }

    /**
     * Get a list of campaigns the user is in
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function campaigns()
    {
        return $this->hasManyThrough(
            'App\Campaign',
            'App\CampaignUser',
            'user_id',
            'id',
            'id',
            'campaign_id'
        );
    }

    /**
     * Get the other campaigns of the user
     * @return mixed
     */
    public function moveCampaignList()
    {
        $campaigns = [0 => ''];
        foreach ($this->campaigns()->whereNotIn('campaign_id', [$this->campaign->id])->get() as $campaign) {
            $campaigns[$campaign->id] = $campaign->name;
        }
        return $campaigns;
    }

    /**
     * Get the user's campaign
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
//    public function campaignRole()
//    {
//        return $this->belongsTo(CampaignUser::class, 'id', 'last_campaign_id');
//    }

    /**
     * @return string
     */
    public function getAvatarUrl()
    {
        if (!empty($this->avatar) && $this->avatar != 'users/default.png') {
            return '/storage/' . $this->avatar;
        } else {
            return '/images/defaults/user.svg';
        }
    }

    /**
     * Determine if the user is currently viewer a campaign as a member or owner
     * @param bool $strict
     * @return bool
     */
    public function member($strict = false)
    {
        die("don't use member anymore");
        if ($strict) {
            return $this->campaign_role == 'member';
        }
        return in_array($this->campaign_role, ['member', 'owner']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany('App\Models\UserLog', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissions()
    {
        return $this->hasMany('App\Models\CampaignPermission', 'user_id');
    }

    /**
     * Get the user's roles
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roles($campaignId = null)
    {
        if (empty($campaignId)) {
            $campaignId = $this->campaign->id;
        }
        return $this->campaignRoles($campaignId);
    }

    /**
     * @param null $campaignId
     * @return mixed
     */
    public function rolesList($campaignId = null)
    {
        if (empty($campaignId)) {
            $campaignId = $this->campaign->id;
        }
        $roles = $this->campaignRoles($campaignId)->get();
        return $roles->implode('name', ', ');
    }

    /**
     * @param $campaignId
     * @return $this
     */
    public function campaignRoles($campaignId)
    {
        return $this->hasManyThrough(
            'App\Models\CampaignRole',
            'App\Models\CampaignRoleUser',
            'user_id',
            'id',
            'id',
            'campaign_role_id'
        )
            ->where('campaign_id', $campaignId);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function campaignRoleUser()
    {
        return $this->hasMany('App\Models\CampaignRoleUser')
            ->where('campaign_id', $this->campaign->id);
    }

    /**
     * Figure out if the user is an admin of the current campaign
     */
    public function isAdmin()
    {
        if ($this->isAdminCached === null) {
            $this->isAdminCached = $this->roles()->where(['is_admin' => true])->count() > 0;
        }
        return $this->isAdminCached;
    }

    /**
     * @return bool
     */
    public function hasCampaigns($count = 0)
    {
        return $this->campaigns()->count() > $count ;
    }
}
