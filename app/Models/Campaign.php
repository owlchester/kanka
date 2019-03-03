<?php

namespace App\Models;

use App\Models\Scopes\CampaignScopes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class Campaign
 * @package App
 *
 * @property string $name
 * @property string $locale
 * @property string $entry
 * @property string $image
 * @property string $join_token
 * @property string $export_path
 * @property string $export_date
 * @property string $visibility
 * @property bool $entity_visibility
 * @property bool $entity_personality_visibility
 * @property string $header_image
 * @property string $system
 * @property EntityMention[] $mentions
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
        'entry',
        'image',
        'join_token',
        'export_path',
        'export_date',
        'visibility',
        'entity_visibility',
        'entity_personality_visibility',
        'header_image',
        'system'
    ];

    use CampaignScopes;

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name'];

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
     * @return mixed
     */
    public function users()
    {
        return $this->hasManyThrough(
            'App\User',
            'App\Models\CampaignUser',
            'campaign_id',
            'id',
            'id',
            'user_id'
        );
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
    public function tags()
    {
        return $this->hasMany('App\Models\Tag');
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
     * @return mixed
     */
    public function conversations()
    {
        return $this->hasMany('App\Models\Conversation');
    }

    /**
     * @return mixed
     */
    public function races()
    {
        return $this->hasMany('App\Models\Race');
    }

    /**
     * List of entities that are mentionned in the campaign's description
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mentions()
    {
        return $this->hasMany('App\Models\EntityMention', 'campaign_id', 'id');
    }

    /**
     * List of entities that are mentionned in the campaign's description
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entities()
    {
        return $this->hasMany('App\Models\Entity', 'campaign_id', 'id');
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
    public function membersList($removedIds = [])
    {
        $members = [];

        foreach ($this->members()->with('user')->get() as $m) {
            if (!in_array($m->user->id, $removedIds)) {
                $members[$m->user->id] = $m->user->name;
            }
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
     * @return string
     */
    public function getMiddlewareLink()
    {
        return 'campaign/' . $this->id;
    }

    /**
     * Campaigns with the most entities
     * @param $query
     * @return mixed
     */
    public function scopeTop($query)
    {
        return $query
            ->select([
                $this->getTable() . '.*',
                DB::raw("(select count(*) from entities where campaign_id = " . $this->getTable() . ".id) as cpt")
            ])
            ->orderBy('cpt', 'desc')
            ;
    }


    /**
     * Campaigns with the most entities
     * @param $query
     * @return mixed
     */
    public function scopeTopMembers($query)
    {
        return $query
            ->select([
                $this->getTable() . '.*',
                DB::raw("(select count(*) from campaign_user where campaign_id = " . $this->getTable() . ".id) as cpt")
            ])
            ->orderBy('cpt', 'desc')
            ;
    }
}
