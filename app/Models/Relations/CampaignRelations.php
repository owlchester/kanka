<?php


namespace App\Models\Relations;


use App\Models\CampaignDashboard;
use App\Models\CampaignDashboardWidget;
use App\Models\CampaignPlugin;
use App\Models\CampaignRole;
use App\Models\CampaignSetting;
use App\Models\CampaignSubmission;
use App\Models\CampaignUser;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityMention;
use App\Models\Image;
use App\Models\Location;
use App\Models\Plugin;
use App\Models\RpgSystem;
use App\Models\Theme;
use App\User;

/**
 * Trait CampaignRelations
 * @package App\Models\Relations
 *
 * @property User[] $users
 * @property User[] $followers
 * @property RpgSystem $rpgSystem
 * @property CampaignRole[] $roles
 *
 * @property EntityMention[] $mentions
 * @property CampaignSetting $setting
 * @property CampaignUser[] $members
 * @property Theme[] $theme
 *
 * @property Entity[] $entities
 * @property Character[] $characters
 * @property Location[] $locations
 *
 * @property Image[] $images
 * @property Plugin[] $plugins
 * @property CampaignPlugin[] $campaignPlugins
 *
 * @property CampaignDashboardWidget[] $widgets
 * @property CampaignDashboard[] $dashboards
 * @property CampaignSubmission[] $submissions
 */
trait CampaignRelations
{
    /**
     * @return mixed
     */
    public function users()
    {
        return $this->hasManyThrough(
            User::class,
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
        return $this->hasMany(CampaignRole::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function characters()
    {
        return $this->hasMany(Character::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
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
    public function maps()
    {
        return $this->hasMany('App\Models\Map');
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function timelines()
    {
        return $this->hasMany('App\Models\Timeline');
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
     * @return mixed
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
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
}
