<?php

namespace App\Models\Relations;

use App\Enums\CampaignExportStatus;
use App\Enums\EntityAssetType;
use App\Models\Ability;
use App\Models\Application;
use App\Models\AttributeTemplate;
use App\Models\Bookmark;
use App\Models\Calendar;
use App\Models\CampaignDashboard;
use App\Models\CampaignDashboardWidget;
use App\Models\CampaignExport;
use App\Models\CampaignFilter;
use App\Models\CampaignFlag;
use App\Models\CampaignFollower;
use App\Models\CampaignImport;
use App\Models\CampaignInvite;
use App\Models\CampaignPlugin;
use App\Models\CampaignRole;
use App\Models\CampaignSetting;
use App\Models\CampaignStyle;
use App\Models\CampaignUser;
use App\Models\Character;
use App\Models\Conversation;
use App\Models\Creature;
use App\Models\DiceRoll;
use App\Models\Entity;
use App\Models\EntityAsset;
use App\Models\EntityMention;
use App\Models\EntityType;
use App\Models\EntityUser;
use App\Models\Event;
use App\Models\Family;
use App\Models\GameSystem;
use App\Models\Genre;
use App\Models\Image;
use App\Models\Item;
use App\Models\Journal;
use App\Models\Location;
use App\Models\Map;
use App\Models\Note;
use App\Models\Organisation;
use App\Models\Playstyle;
use App\Models\Plugin;
use App\Models\Post;
use App\Models\Quest;
use App\Models\Race;
use App\Models\Relation;
use App\Models\Spotlight;
use App\Models\Tag;
use App\Models\Theme;
use App\Models\Timeline;
use App\Models\User;
use App\Models\Webhook;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

/**
 * Trait CampaignRelations
 *
 * @property Collection|User[] $users
 * @property Collection|User[] $followers
 * @property Collection|CampaignRole[] $roles
 * @property CampaignRole $publicRole
 * @property Collection|EntityMention[] $mentions
 * @property Collection|CampaignSetting $setting
 * @property Collection|CampaignUser[] $members
 * @property Collection|Theme[] $theme
 * @property Collection|Webhook[] $webhooks
 * @property Collection|Entity[] $entities
 * @property Collection|Character[] $characters
 * @property Collection|Location[] $locations
 * @property Collection|Image[] $images
 * @property Collection|Plugin[] $plugins
 * @property Collection|CampaignPlugin[] $campaignPlugins
 * @property Collection|CampaignDashboardWidget[] $widgets
 * @property Collection|CampaignDashboard[] $dashboards
 * @property Collection|Application[] $applications
 * @property Collection|CampaignStyle[] $styles
 * @property Collection|Genre[] $genres
 * @property Collection|GameSystem[] $systems
 * @property Collection|CampaignExport[] $campaignExports
 * @property Collection|CampaignExport[] $queuedCampaignExports
 * @property Collection|EntityType[] $entityTypes
 * @property Collection|CampaignFlag[] $flags
 * @property ?Spotlight $spotlight
 */
trait CampaignRelations
{
    protected Collection $nonAdmins;

    /**
     * @return BelongsToMany<
     *     User,
     *     $this,
     *     CampaignUser
     * >
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'campaign_user')->using('App\Models\CampaignUser');
    }

    /**
     * @return BelongsToMany<
     *     User,
     *     $this,
     *     CampaignFollower
     * >
     */
    public function followers(): BelongsToMany
    {
        return $this
            ->belongsToMany(User::class, 'campaign_followers')
            ->using(CampaignFollower::class);
    }

    /**
     * @return BelongsTo<CampaignSetting, $this>
     */
    public function setting(): BelongsTo
    {
        return $this->belongsTo('App\Models\CampaignSetting', 'id', 'campaign_id');
    }

    /**
     * @return HasMany<CampaignUser, $this>
     */
    public function members(): HasMany
    {
        return $this->hasMany('App\Models\CampaignUser');
    }

    public function nonAdmins(): Collection
    {
        if (isset($this->nonAdmins)) {
            return $this->nonAdmins;
        }
        $this->nonAdmins = new Collection;
        // We can't exclude admins through pure SQL as some members might be role-less in weird edge cases
        foreach ($this->members()->with(['user', 'user.campaignRoles', 'user.tutorials'])->get() as $member) {
            $isAdmin = false;
            /** @var CampaignRole $campaignRole */
            foreach ($member->user->campaignRoles as $campaignRole) {
                // Skip roles from other campaigns. This can probably be improved?
                if ($campaignRole->campaign_id !== $this->id) {
                    continue;
                }
                if ($campaignRole->isAdmin()) {
                    $isAdmin = true;
                }
            }
            if ($isAdmin) {
                continue;
            }

            $this->nonAdmins->add($member);
        }

        return $this->nonAdmins;
    }

    /**
     * @return HasMany<CampaignRole, $this>
     */
    public function roles(): HasMany
    {
        return $this->hasMany(CampaignRole::class);
    }

    public function publicRole(): HasOne
    {
        return $this->roles()->public()->one();
    }

    /**
     * @return HasMany<Webhook, $this>
     */
    public function webhooks(): HasMany
    {
        return $this->hasMany(Webhook::class);
    }

    /**
     * @return HasMany<Character, $this>
     */
    public function characters(): HasMany
    {
        return $this->hasMany(Character::class);
    }

    /**
     * @return HasMany<Location, $this>
     */
    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }

    /**
     * @return HasMany<Calendar, $this>
     */
    public function calendars(): HasMany
    {
        return $this->hasMany(Calendar::class);
    }

    /**
     * @return HasMany<Event, $this>
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /**
     * @return HasMany<Family, $this>
     */
    public function families(): HasMany
    {
        return $this->hasMany(Family::class);
    }

    /**
     * @return HasMany<Item, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    /**
     * @return HasMany<Journal, $this>
     */
    public function journals(): HasMany
    {
        return $this->hasMany(Journal::class);
    }

    /**
     * @return HasMany<Map, $this>
     */
    public function maps(): HasMany
    {
        return $this->hasMany(Map::class);
    }

    /**
     * @return HasMany<Note, $this>
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    /**
     * @return HasMany<Organisation, $this>
     */
    public function organisations(): HasMany
    {
        return $this->hasMany(Organisation::class);
    }

    /**
     * @return HasMany<Quest, $this>
     */
    public function quests(): HasMany
    {
        return $this->hasMany(Quest::class);
    }

    /**
     * @return HasMany<Ability, $this>
     */
    public function abilities(): HasMany
    {
        return $this->hasMany(Ability::class);
    }

    /**
     * @return HasMany<AttributeTemplate, $this>
     */
    public function attributeTemplates(): HasMany
    {
        return $this->hasMany(AttributeTemplate::class);
    }

    /**
     * @return HasMany<Tag, $this>
     */
    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }

    /**
     * @return HasMany<Timeline, $this>
     */
    public function timelines(): HasMany
    {
        return $this->hasMany(Timeline::class);
    }

    /**
     * @return HasMany<Bookmark, $this>
     */
    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class)
            ->with(['dashboard']);
    }

    /**
     * @return HasMany<DiceRoll, $this>
     */
    public function diceRolls(): HasMany
    {
        return $this->hasMany(DiceRoll::class);
    }

    /**
     * @return HasMany<Conversation, $this>
     */
    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    /**
     * @return HasMany<Race, $this>
     */
    public function races(): HasMany
    {
        return $this->hasMany(Race::class);
    }

    /**
     * @return HasMany<Creature, $this>
     */
    public function creatures(): HasMany
    {
        return $this->hasMany(Creature::class);
    }

    public function images(): HasMany|Image
    {
        return $this->hasMany(Image::class)
            ->where('is_default', false);
    }

    /**
     * List of entities that are mentioned in the campaign's description
     *
     * @return HasMany<EntityMention, $this>
     */
    public function mentions(): HasMany
    {
        return $this->hasMany('App\Models\EntityMention', 'campaign_id', 'id');
    }

    /**
     * @return HasMany<Entity, $this>
     */
    public function entities(): HasMany
    {
        return $this->hasMany(Entity::class, 'campaign_id', 'id');
    }

    /**
     * @return BelongsTo<Theme, $this>
     */
    public function theme(): BelongsTo
    {
        return $this->belongsTo('App\Models\Theme');
    }

    /**
     * @return HasMany<Application, $this>
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    /**
     * @return HasMany<Relation, $this>
     */
    public function entityRelations(): HasMany
    {
        return $this->hasMany('App\Models\Relation');
    }

    /**
     * @return HasManyThrough<Post, Entity, $this>
     */
    public function posts(): HasManyThrough
    {
        return $this->hasManyThrough(Post::class, Entity::class);
    }

    /**
     * @return HasManyThrough<EntityAsset, Entity, $this>
     */
    public function entityAliases(): HasManyThrough
    {
        return $this->hasManyThrough(EntityAsset::class, Entity::class)->where('entity_assets.type_id', EntityAssetType::alias);
    }

    /**
     * @return BelongsToMany<Plugin, $this>
     */
    public function plugins(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Plugin', 'campaign_plugins', 'campaign_id', 'plugin_id')
            // ->using('App\Models\CampaignPlugin')
            ->withPivot('is_active')
            ->withPivot('plugin_version_id');
    }

    /**
     * @return HasMany<CampaignPlugin, $this>
     */
    public function campaignPlugins(): HasMany
    {
        return $this->hasMany(CampaignPlugin::class);
    }

    /**
     * @return HasMany<CampaignDashboardWidget, $this>
     */
    public function widgets(): HasMany
    {
        return $this->hasMany(CampaignDashboardWidget::class);
    }

    /**
     * @return HasMany<CampaignDashboard, $this>
     */
    public function dashboards(): HasMany
    {
        return $this->hasMany(CampaignDashboard::class);
    }

    /**
     * @return HasMany<CampaignExport, $this>
     */
    public function campaignExports(): HasMany
    {
        return $this->hasMany(CampaignExport::class);
    }

    public function queuedCampaignExports()
    {
        return $this->campaignExports()
            ->whereIn('status', [
                CampaignExportStatus::scheduled,
                CampaignExportStatus::running,
            ]);
    }

    /**
     * @return HasMany<CampaignImport, $this>
     */
    public function campaignImports(): HasMany
    {
        return $this->hasMany(CampaignImport::class);
    }

    /**
     * @return HasMany<CampaignStyle, $this>
     */
    public function styles(): HasMany
    {
        return $this->hasMany(CampaignStyle::class);
    }

    /**
     * @return BelongsToMany<
     *     User,
     *     $this,
     *     EntityUser
     * >
     */
    public function editingUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'entity_user')
            ->using(EntityUser::class)
            ->withPivot('type_id');
    }

    /**
     * @return HasMany<CampaignInvite, $this>
     */
    public function invites(): HasMany
    {
        return $this->hasMany('App\Models\CampaignInvite');
    }

    /**
     * @return BelongsToMany<Genre, $this>
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    /**
     * @return BelongsToMany<GameSystem, $this>
     */
    public function systems(): BelongsToMany
    {
        return $this->belongsToMany(GameSystem::class, 'campaign_system', 'campaign_id', 'system_id');
    }

    /**
     * @return HasMany<EntityType, $this>
     */
    public function entityTypes(): HasMany
    {
        return $this->hasMany(EntityType::class);
    }

    /**
     * List of the campaign's flags
     *
     * @return HasMany<CampaignFlag, $this>
     */
    public function flags(): HasMany
    {
        return $this->hasMany(CampaignFlag::class, 'campaign_id', 'id');
    }

    /**
     * @return HasOne<Spotlight, $this>
     */
    public function spotlight(): HasOne
    {
        return $this->hasOne(Spotlight::class);
    }

    /**
     * @return BelongsToMany<Playstyle, $this>
     */
    public function playstyles(): BelongsToMany
    {
        return $this->belongsToMany(Playstyle::class);
    }

    /**
     * @return HasMany<CampaignFilter, $this>
     */
    public function filters(): HasMany
    {
        return $this->hasMany(CampaignFilter::class);
    }
}
