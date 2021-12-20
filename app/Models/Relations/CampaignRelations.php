<?php


namespace App\Models\Relations;


use App\Models\Ability;
use App\Models\Calendar;
use App\Models\CampaignDashboard;
use App\Models\CampaignDashboardWidget;
use App\Models\CampaignPlugin;
use App\Models\CampaignRole;
use App\Models\CampaignSetting;
use App\Models\CampaignStyle;
use App\Models\CampaignSubmission;
use App\Models\CampaignUser;
use App\Models\Character;
use App\Models\Conversation;
use App\Models\DiceRoll;
use App\Models\Entity;
use App\Models\EntityMention;
use App\Models\Event;
use App\Models\Family;
use App\Models\Image;
use App\Models\Item;
use App\Models\Journal;
use App\Models\Location;
use App\Models\Map;
use App\Models\MenuLink;
use App\Models\Note;
use App\Models\Organisation;
use App\Models\Plugin;
use App\Models\Quest;
use App\Models\Race;
use App\Models\RpgSystem;
use App\Models\Tag;
use App\Models\Theme;
use App\Models\Timeline;
use App\User;
use Illuminate\Support\Collection;

/**
 * Trait CampaignRelations
 * @package App\Models\Relations
 *
 * @property User[] $users
 * @property User[] $followers
 * @property RpgSystem $rpgSystem
 * @property Collection|CampaignRole[] $roles
 *
 * @property Collection|EntityMention[] $mentions
 * @property Collection|CampaignSetting $setting
 * @property Collection|CampaignUser[] $members
 * @property Collection|Theme[] $theme
 *
 * @property Collection|Entity[] $entities
 * @property Collection|Character[] $characters
 * @property Collection|Location[] $locations
 *
 * @property Collection|Image[] $images
 * @property Collection|Plugin[] $plugins
 * @property Collection|CampaignPlugin[] $campaignPlugins
 *
 * @property Collection|CampaignDashboardWidget[] $widgets
 * @property Collection|CampaignDashboard[] $dashboards
 * @property Collection|CampaignSubmission[] $submissions
 * @property Collection|CampaignStyle[] $styles
 */
trait CampaignRelations
{
    /**
     * @return mixed
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'campaign_user')->using('App\Models\CampaignUser');
    }

    /**
     * @return mixed
     */
    public function followers()
    {
        return $this->belongsToMany('App\User', 'campaign_followers')->using('App\Models\CampaignFollower');
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
        return $this->hasMany(CampaignRole::class);
    }

    /**
     * @return Character|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function characters()
    {
        return $this->hasMany(Character::class);
    }

    /**
     * @return Location|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    /**
     * @return Calendar|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calendars()
    {
        return $this->hasMany(Calendar::class);
    }

    /**
     * @return Event|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * @return Family|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function families()
    {
        return $this->hasMany(Family::class);
    }

    /**
     * @return Item|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    /**
     * @return Journal|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function journals()
    {
        return $this->hasMany(Journal::class);
    }

    /**
     * @return Map|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function maps()
    {
        return $this->hasMany(Map::class);
    }

    /**
     * @return Note|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    /**
     * @return Organisation|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function organisations()
    {
        return $this->hasMany(Organisation::class);
    }

    /**
     * @return Quest|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quests()
    {
        return $this->hasMany(Quest::class);
    }

    /**
     * @return Ability|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function abilities()
    {
        return $this->hasMany(Ability::class);
    }

    /**
     * @return Tag|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    /**
     * @return Timeline|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function timelines()
    {
        return $this->hasMany(Timeline::class);
    }

    /**
     * @return MenuLink|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menuLinks()
    {
        return $this->hasMany(MenuLink::class);
    }

    /**
     * @return DiceRoll|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function diceRolls()
    {
        return $this->hasMany(DiceRoll::class);
    }

    /**
     * @return Conversation|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    /**
     * @return Race|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function races()
    {
        return $this->hasMany(Race::class);
    }

    /**
     * @return mixed|Image
     */
    public function images()
    {
        return $this->hasMany(Image::class)
            ->where('is_default', false);
    }

    /**
     * List of entities that are mentioned in the campaign's description
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mentions()
    {
        return $this->hasMany('App\Models\EntityMention', 'campaign_id', 'id');
    }

    /**
     * List of entities that are mentioned in the campaign's description
     * @return Entity|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entities()
    {
        return $this->hasMany(Entity::class, 'campaign_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function theme()
    {
        return $this->belongsTo('App\Models\Theme');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submissions()
    {
        return $this->hasMany('App\Models\CampaignSubmission');
    }

    /**
     * @return mixed
     */
    public function entityRelations()
    {
        return $this->hasMany('App\Models\Relation');
    }

    /**
     * @return mixed
     */
    public function plugins()
    {
        return $this->belongsToMany('App\Models\Plugin', 'campaign_plugins', 'campaign_id', 'plugin_id')
            //->using('App\Models\CampaignPlugin')
            ->withPivot('is_active')
            ->withPivot('plugin_version_id')
        ;
    }

    /**
     * @return mixed
     */
    public function campaignPlugins()
    {
        return $this->hasMany(CampaignPlugin::class);
    }

    public function widgets()
    {
        return $this->hasMany(CampaignDashboardWidget::class);
    }

    public function dashboards()
    {
        return $this->hasMany(CampaignDashboard::class);
    }

    public function styles()
    {
        return $this->hasMany(CampaignStyle::class);
    }
}
