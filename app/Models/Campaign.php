<?php

namespace App\Models;

use App\Facades\Mentions;
use App\Models\Concerns\Boosted;
use App\Models\Scopes\CampaignScopes;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
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
 * @property string $excerpt
 * @property string $css
 * @property string $theme
 * @property int $boost_count
 * @property integer $visible_entity_count
 * @property EntityMention[] $mentions
 * @property CampaignSetting $setting
 * @property CampaignUser[] $members
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
        'excerpt',
        'image',
        'join_token',
        'export_path',
        'export_date',
        'visibility',
        'entity_visibility',
        'entity_personality_visibility',
        'header_image',
        'system',
        'theme_id',
        'css'
    ];

    use CampaignScopes;
    use Boosted;

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name'];

    protected $cachedUserInCampaign = null;
    protected $cachedUserRole = null;

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
    public function followers()
    {
        return $this->hasManyThrough(
            'App\User',
            'App\Models\CampaignFollower',
            'campaign_id',
            'id',
            'id',
            'user_id'
        );
    }

    /**
     * @return mixed
     */
    public function rpgSystems()
    {
        return $this->belongsToMany('App\Models\RpgSystem');
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function characters()
    {
        return $this->hasMany('App\Models\Character');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locations()
    {
        return $this->hasMany('App\Models\Location');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calendars()
    {
        return $this->hasMany('App\Models\Calendar');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany('App\Models\Event');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function families()
    {
        return $this->hasMany('App\Models\Family');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function journals()
    {
        return $this->hasMany('App\Models\Journal');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes()
    {
        return $this->hasMany('App\Models\Note');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function organisations()
    {
        return $this->hasMany('App\Models\Organisation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quests()
    {
        return $this->hasMany('App\Models\Quest');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function abilities()
    {
        return $this->hasMany('App\Models\Ability');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function theme()
    {
        return $this->belongsTo('App\Models\Theme');
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
     * Does the campaign has a preview text that can be displayed
     * @return bool
     */
    public function hasPreview(): bool
    {
        return !empty($this->preview());
    }

    /**
     * Preview text for the dashboard
     * @return string
     */
    public function preview(): string
    {
        if (!empty(strip_tags($this->excerpt))) {
            return $this->excerpt();
        }
        if (!empty(strip_tags($this->entry))) {
            return strip_tags(substr($this->entry(), 0, 1000)) . ' ...';
        }
        return '';
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
     * Determine if the user is in the campaign
     * @return bool
     */
    public function userIsMember(): bool
    {
        if ($this->cachedUserInCampaign === null) {
            $this->cachedUserInCampaign = $this->members()
                    ->where('user_id', Auth::user()->id)
                    ->count() == 1;
        }
        return $this->cachedUserInCampaign;
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
        // Can't disable attribute templates
        if ($entity == 'attribute_templates') {
            return true;
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
    public function getMiddlewareLink(): string
    {
        return 'campaign/' . $this->id;
    }

    /**
     * Determine if the user is currently following the campaign
     * @return bool
     */
    public function isFollowing(): bool
    {
        return $this->followers()->where('user_id', Auth::user()->id)->count() === 1;
    }

    /**
     * Determine if a campaign is public
     * @return bool
     */
    public function isPublic(): bool
    {
        return $this->visibility == self::VISIBILITY_PUBLIC;
    }

    /**
     * @return mixed
     */
    public function entry()
    {
        return Mentions::mapCampaign($this);
    }

    /**
     * @return mixed
     */
    public function getEntryForEditionAttribute()
    {
        return Mentions::editCampaign($this);
    }

    /**
     * @return mixed
     */
    public function excerpt()
    {
        return Mentions::mapCampaign($this, 'excerpt');
    }
    /**
     * @return mixed
     */
    public function getExcerptForEditionAttribute()
    {
        return Mentions::editCampaign($this, 'excerpt');
    }

    /**
     * Link to the dashboard
     * @return string
     */
    public function dashboard(): string
    {
        return link_to(App::getLocale() . '/' . $this->getMiddlewareLink(), e($this->name));
    }
}
