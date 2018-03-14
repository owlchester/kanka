<?php

namespace App;

use App\Campaign;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DateTime;

class User extends \TCG\Voyager\Models\User
{
    /**
     * Cached calculation if the user is an admin of the current campaign he is viewing
     * @var null
     */
    protected $isAdminCached = null;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'last_campaign_id', 'provider', 'provider_id', 'newsletter', 'locale', 'timezone',
        'campaign_role',
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
    public function campaign()
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
     * Get the user's campaign
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
//    public function campaignRole()
//    {
//        return $this->belongsTo(CampaignUser::class, 'id', 'last_campaign_id');
//    }

    /**
     * @param string $field
     * @param bool $full
     * @return string
     */
    public function elapsed($field = 'updated_at', $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($this->$field);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . trans('datetime.' . ($v . ($diff->$k > 1 ? 's' : '')));
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) {
            $string = array_slice($string, 0, 1);
        }
        // Formatting
        if ($string) {
            return  trans('datetime.elapsed_ago', ['duration' => implode(', ', $string)]);
        }
        return trans('datetime.just_now');
    }

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
    public function roles()
    {
        return $this->hasManyThrough('App\Models\CampaignRole', 'App\Models\CampaignRoleUser', 'user_id', 'id', 'id', 'campaign_role_id')
            ->where('campaign_id', $this->campaign->id);
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
}
