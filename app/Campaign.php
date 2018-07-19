<?php

namespace App;

use App\Models\MiscModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class Campaign
 * @package App
 */
class Campaign extends MiscModel
{
    /**
     * Visibility of a campaign
     */
    const VISIBILITY_PRIVATE = 'private';
    const VISIBILITY_REVIEW = 'review';
    const VISIBILITY_PUBLIC = 'public';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'locale',
        'description',
        'image',
        'join_token',
        'export_path',
        'export_date',
        'visibility',
    ];

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name'];

    /**
     * @return mixed
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'campaign_user');
    }

    /**
     * @return mixed
     */
    public function setting()
    {
        return $this->belongsTo('App\Models\CampaignSetting', 'id', 'campaign_id');
    }

    /**
     * @return mixed
     */
    public function members()
    {
        return $this->hasMany('App\Models\CampaignUser');
    }

    /**
     * @return mixed
     */
    public function roles()
    {
        return $this->hasMany('App\Models\CampaignRole');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany$
     */
    public function characters()
    {
        return $this->hasMany('App\Models\Character');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany$
     */
    public function locations()
    {
        return $this->hasMany('App\Models\Location');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany$
     */
    public function calendars()
    {
        return $this->hasMany('App\Models\Calendar');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany$
     */
    public function events()
    {
        return $this->hasMany('App\Models\Event');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany$
     */
    public function families()
    {
        return $this->hasMany('App\Models\Family');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany$
     */
    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany$
     */
    public function journals()
    {
        return $this->hasMany('App\Models\Journal');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany$
     */
    public function notes()
    {
        return $this->hasMany('App\Models\Note');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany$
     */
    public function organisations()
    {
        return $this->hasMany('App\Models\Organisation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany$
     */
    public function quests()
    {
        return $this->hasMany('App\Models\Quest');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany$
     */
    public function sections()
    {
        return $this->hasMany('App\Models\Section');
    }

    /**
     * @return mixed
     */
    public function menuLinks()
    {
        return $this->hasMany('App\Models\MenuLink');
    }

    /**
     * @return mixed
     */
    public function diceRolls()
    {
        return $this->hasMany('App\Models\DiceRoll');
    }

    /**
     * Helper function to know if a campaign has permissions. This is true as soon as the campaign has several roles
     * @return bool
     */
    public function hasPermissions()
    {
        return $this->roles()->count() > 1;
    }

    /**
     * @return array
     */
    public function membersList()
    {
        $members = [];

        foreach ($this->members()->with('user')->get() as $m) {
            $members[$m->user->id] = $m->user->name;
        }

        return $members;
    }

    /**
     * @return mixed
     */
    public function invites()
    {
        return $this->hasMany('App\Models\CampaignInvite');
    }

    /**
     * @return mixed
     */
    public function unusedInvites()
    {
        return $this->invites()->where('is_active', true);
    }

    /**
     * @return bool
     */
    public function owner()
    {
        return $this->owners()->where('user_id', Auth::user()->id)->count() == 1;
    }

    /**
     * List of owners
     * @return mixed
     */
    public function owners()
    {
        die("deprecated call to Campaign:owners");
        return $this->members()->where('is_admin', '1');
    }

    /**
     * Get a list of users who are admins of the campaign
     * @return array
     */
    public function admins()
    {
        $users = [];
        foreach ($this->roles()->with('users')->where('is_admin', '1')->get() as $role) {
            foreach ($role->users as $user) {
                if (!isset($users[$user->id])) {
                    $users[$user->user->id] = $user->user;
                }
            }
        }
        return $users;
    }

    /**
     * @return bool
     */
    public function member()
    {
        die("deprecated call to campaign:member");
        return $this->members()
                ->where('role', 'member')
                ->where('user_id', Auth::user()->id)
                ->count() == 1;
    }

    /**
     * @return bool
     */
    public function user()
    {
        return $this->members()
            ->where('user_id', Auth::user()->id)
            ->count() == 1;
    }

    /**
     * @return int
     */
    public function role()
    {
        $member = $this->members()
            ->where('user_id', Auth::user()->id)
            ->first();
        if ($member) {
            return $member->role;
        }
        return 0;
    }

    /**
     * Determine if a campaign has an entity enabled or not
     *
     * @param $entity
     * @return bool
     */
    public function enabled($entity)
    {
        if ($this->setting->$entity) {
            return $this->setting->$entity;
        }
        return false;
    }

    /**
     * Get the is public checkbox for the campaign form.
     */
    public function getIsPublicAttribute()
    {
        return $this->visibility != self::VISIBILITY_PRIVATE;
    }

    /**
     * @param $query
     * @param $visibility
     * @return mixed
     */
    public function scopeVisibility($query, $visibility)
    {
        return $query->where('visibility', $visibility);
    }

    /**
     * Admin crud datagrid
     * @param $query
     * @return mixed
     */
    public function scopeAdmin($query)
    {
        return $query->visibility(Campaign::VISIBILITY_REVIEW);
    }

    /**
     * @return string
     */
    public function getMiddlewareLink()
    {
        return 'campaign/' . $this->id;
    }
}
