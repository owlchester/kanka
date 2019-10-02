<?php

namespace App;

use App\Models\Campaign;
use App\Facades\CampaignLocalization;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DateTime;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 * @package App
 *
 * @property string $name
 * @property string $email
 * @property integer $last_campaign_id
 * @property string $provider
 * @property integer $provider_id
 * @property string $last_login_at
 * @property integer $welcome_campaign_id
 * @property boolean $newsletter
 * @property boolean $has_last_login_sharing
 * @property string $patreon_pledge
 */
class User extends \TCG\Voyager\Models\User
{
    const PLEDGE_KOBOLD = 'Kobold';
    const PLEDGE_GOBLIN = 'Goblin';
    const PLEDGE_OWLBEAR = 'Owlbear';
    const PLEDGE_ELEMENTAL = 'Elemental';
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
        'locale', // Keep this for the LocaleChange middleware
        'last_login_at',
        'has_last_login_sharing',
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
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'last_login_at',
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
     * @return mixed
     */
    public function following()
    {
        return $this->hasManyThrough(
            'App\Models\Campaign',
            'App\Models\CampaignFollower',
            'user_id',
            'id',
            'id',
            'campaign_id'
        );
    }

    /**
     * Get the other campaigns of the user
     * @param bool $hasEmpty
     * @return array
     */
    public function moveCampaignList(bool $hasEmpty = true): array
    {
        $campaigns = $hasEmpty ? [0 => ''] : [];
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
     * @param null $campaignId
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
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

    /**
     * Check if the user has other campaigns than the current one
     * @param int $campaignId
     * @return bool
     */
    public function hasOtherCampaigns(int $campaignId): bool
    {
        return $this->campaigns()->where('campaign_id', '!=', $campaignId)->count() > 0;
    }

    /**
     * Get the user's avatar
     * @param bool $thumb
     * @return string
     */
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
        $this->setSettingsOption('pledge', $value);
    }

    /**
     * Last read release
     * @param $value
     */
    public function setReleaseAttribute($value)
    {
        $this->setSettingsOption('release', $value);
    }

    /**
     * @param $value
     */
    public function setPatreonEmailAttribute($value)
    {
        $this->setSettingsOption('patreon_email', $value);
    }

    /**
     * @param $value
     */
    public function setPatreonFullnameAttribute($value)
    {
        $this->setSettingsOption('patreon_fullname', $value);
    }

    /**
     * @return mixed
     */
    public function getPatreonFullnameAttribute()
    {
        return $this->settings['patreon_fullname'];
    }

    /**
     * @return mixed
     */
    public function getReleaseAttribute()
    {
        return array_get($this->settings, 'release', null);
    }

    /**
     * @param $value
     */
    public function setEditorAttribute($value)
    {
        $this->setSettingsOption('editor', $value);
    }

    /**
     * @return mixed
     */
    public function getEditorAttribute()
    {
        return array_get($this->settings, 'editor', null);
    }

    /**
     * @param $value
     */
    public function setDefaultNestedAttribute($value)
    {
        $this->setSettingsOption('default_nested', $value);
    }

    /**
     * @return mixed
     */
    public function getDefaultNestedAttribute()
    {
        return array_get($this->settings, 'default_nested', null);
    }

    /**
     * @param $key
     * @param $value
     */
    protected function setSettingsOption($key, $value)
    {
        $this->attributes['settings'] = collect($this->settings)->merge([$key => $value]);
    }

    /**
     * @param $data
     * @return $this
     */
    public function saveSettings($data)
    {
        $this->editor = array_get($data, 'editor', null);
        if (empty($this->editor)) {
            unset($this->attributes['settings']['editor']);
        }
        $this->default_nested = array_get($data, 'default_nested', null);
        if (empty($this->default_nested)) {
            unset($this->attributes['settings']['default_nested']);
        }
        return $this;
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
     * @return bool
     */
    public function isGoblinPatron()
    {
        return ($this->hasRole('patreon') && !empty($this->patreon_pledge)
                && $this->patreon_pledge != self::PLEDGE_KOBOLD)
           || $this->hasRole('admin')
        ;
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

    /**
     * Users who most log in
     * @param $query
     * @return mixed
     */
    public function scopeTop($query)
    {
        return $query
            ->select([
                $this->getTable() . '.*',
                DB::raw("(select count(*) from user_logs where user_id = " . $this->getTable()
                    . ".id and action = 'login') as cpt")
            ])
            ->orderBy('cpt', 'desc')
            ;
    }


    /**
     * Users grouped by themes
     * @param $query
     * @return mixed
     */
    public function scopeThemes($query)
    {
        return $query
            ->select([
                $this->getTable() . '.theme',
                DB::raw("count(*) as cpt")
            ])
            ->groupBy('theme')
            ->orderBy('cpt', 'desc')
            ;
    }


    /**
     * List of boosts the user is giving
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function boosts()
    {
        return $this->hasMany('App\Models\CampaignBoost', 'user_id', 'id');
    }

    /**
     * Get available boosts for the user
     * @return int
     */
    public function availableBoosts(): int
    {
        return $this->maxBoosts() - $this->boosting();
    }

    /**
     * Get amount of campaigns the user is boosting
     * @return int
     */
    public function boosting(): int
    {
        return $this->boosts->count();
    }

    /**
     * Get max number of boosts a user can give
     * @return int
     */
    public function maxBoosts(): int
    {
        if (!$this->isPatron()) {
            return 0;
        }

        $levels = [
            self::PLEDGE_KOBOLD => 0,
            self::PLEDGE_GOBLIN => 1,
            self::PLEDGE_ELEMENTAL => 5,
        ];

        // Default 3 for admins and owlbears
        return Arr::get($levels, $this->patreon_pledge, 3);
    }
}
