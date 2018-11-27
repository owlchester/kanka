<?php

namespace App;

use App\Models\Campaign;
use App\Facades\CampaignLocalization;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DateTime;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;

class User extends \TCG\Voyager\Models\User
{
    /**
     * Cached calculation if the user is an admin of the current campaign he is viewing
     * @var null
     */
    protected $isAdminCached = null;

    protected static $currentCampaign = false;

    protected $cachedHasCampaign = null;


    public $additional_attributes = ['patreon_fullname'];

    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_campaign_id',
        'provider',
        'provider_id',
        'newsletter',
        'timezone',
        'campaign_role',
        'theme',
        'date_format',
        'default_pagination',
        'locale' // Keep this for the LocaleChange middleware
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
     * Get the user's campaign.
     * This is the equivalent of calling user->campaign or user->getCampaign
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
            'App\Models\Campaign',
            'App\Models\CampaignUser',
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
    public function getAvatarUrl($thumb = false)
    {
        if (!empty($this->avatar) && $this->avatar != 'users/default.png') {
            return Storage::url(($thumb ? str_replace('.', '_thumb.', $this->avatar) : $this->avatar));
        } else {
            return '/images/defaults/user.svg';
        }
    }

    /**
     * @param bool $thumb
     * @return string
     */
    public function getImageUrl($thumb = false)
    {
        if (empty($this->avatar)) {
            return asset('/images/defaults/' . $this->getTable() . ($thumb ? '_thumb' : null) . '.jpg');
        } else {
            return Storage::url(($thumb ? str_replace('.', '_thumb.', $this->avatar) : $this->avatar));
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
//    public function roles($campaignId = null)
//    {
//        if (empty($campaignId)) {
//            $campaignId = $this->campaign->id;
//        }
//        return $this->campaignRoles($campaignId);
//    }

    /**
     * @param null $campaignId
     * @return mixed
     */
    public function rolesList($campaignId = null)
    {
        if (empty($campaignId) && !empty($this->campaign)) {
            $campaignId = $this->campaign->id;
        }
        $roles = $this->campaignRoles($campaignId)->get();
        return $roles->implode('name', ', ');
    }

    /**
     * @param $campaignId
     * @return $this
     */
    public function campaignRoles($campaignId = null)
    {
        if (empty($campaignId) && !empty($this->campaign)) {
            $campaignId = $this->campaign->id;
        }

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
            $this->isAdminCached = $this->campaignRoles()->where(['is_admin' => true])->count() > 0;
        }
        return $this->isAdminCached;
    }

    /**
     * Check if a user has campaigns
     * @return bool
     */
    public function hasCampaigns($count = 0)
    {
        if ($this->cachedHasCampaign === null) {
            $this->cachedHasCampaign = $this->campaigns()->count() > $count;
        }
        return $this->cachedHasCampaign;
    }

    public function getAvatar($thumb = false)
    {
        return "<span class=\"entity-image\" style=\"background-image: url('" .
            $this->getImageUrl(true) . "');\" title=\"" . e($this->name) . "\"></span>";
    }


    /**
     * @param $value
     */
    public function setPledgeAttribute($value)
    {
        $this->attributes['settings'] = collect($this->settings)->merge(['pledge' => $value]);
    }

    /**
     * @param $value
     */
    public function setPatreonEmailAttribute($value)
    {
        $this->attributes['settings'] = collect($this->settings)->merge(['patreon_email' => $value]);
    }

    /**
     * @param $value
     */
    public function setPatreonFullnameAttribute($value)
    {
        $this->attributes['settings'] = collect($this->settings)->merge(['patreon_fullname' => $value]);
    }

    /**
     * @return mixed
     */
    public function getPatreonFullnameAttribute()
    {
        return $this->settings['patreon_fullname'];
    }

    /**
     * Get max file size of user
     * @param bool $readable
     * @return int|string
     */
    public function maxUploadSize($readable = false, $what = 'image')
    {
        if ($this->isPatron()) {
            if ($what == 'map') {
                return $readable ? '10MB' : 10240;
            }
            return $readable ? '8MB' : 8192;
        }
        return $readable ? '2MB' : 2048;
    }

    /**
     * Determine if a user is a patron
     * @return bool
     */
    public function isPatron()
    {
        return $this->hasRole('patreon') || $this->hasRole('admin');
    }

    /**
     * Created today
     * @param $query
     * @return mixed
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', Carbon::today());
    }

    /**
     * Created today
     * @param $query
     * @return mixed
     */
    public function scopeStartOfMonth($query)
    {
        return $query->whereDate('created_at', '>=', Carbon::now()->startOfMonth());
    }
}
