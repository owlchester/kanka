<?php

namespace App\Models\Relations;

use App\Models\Ability;
use App\Models\Application;
use App\Models\AttributeTemplate;
use App\Models\Bookmark;
use App\Models\Calendar;
use App\Models\CampaignDashboard;
use App\Models\CampaignDashboardWidget;
use App\Models\CampaignExport;
use App\Models\CampaignFlag;
use App\Models\CampaignFollower;
use App\Models\CampaignImport;
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
use App\Models\Plugin;
use App\Models\Post;
use App\Models\Quest;
use App\Models\Race;
use App\Models\Tag;
use App\Models\Theme;
use App\Models\Timeline;
use App\Models\User;
use App\Models\Webhook;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Collection;

/**
 * Trait CampaignRelations
 *
 * @property Collection|User[] $users
 * @property Collection|User[] $followers
 * @property Collection|CampaignRole[] $roles
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
 */
trait CampaignRelations
{
    protected Collection $nonAdmins;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<
     *     \App\Models\User,
     *     $this,
     *     \App\Models\CampaignUser
     * >
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'campaign_user')->using('App\Models\CampaignUser');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<
     *     \App\Models\User,
     *     $this,
     *     \App\Models\CampaignFollower
     * >
     */
    public function followers(): BelongsToMany
    {
        return $this
            ->belongsToMany(User::class, 'campaign_followers')
            ->using(CampaignFollower::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\CampaignSetting, $this>
     */
    public function setting(): BelongsTo
    {
        return $this->belongsTo('App\Models\CampaignSetting', 'id', 'campaign_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\CampaignUser, $this>
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\CampaignRole, $this>
     */
    public function roles(): HasMany
    {
        return $this->hasMany(CampaignRole::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Webhook, $this>
     */
    public function webhooks(): HasMany
    {
        return $this->hasMany(Webhook::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Character, $this>
     */
    public function characters(): HasMany
    {
        return $this->hasMany(Character::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Location, $this>
     */
    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Calendar, $this>
     */
    public function calendars(): HasMany
    {
        return $this->hasMany(Calendar::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Event, $this>
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Family, $this>
     */
    public function families(): HasMany
    {
        return $this->hasMany(Family::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Item, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Journal, $this>
     */
    public function journals(): HasMany
    {
        return $this->hasMany(Journal::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Map, $this>
     */
    public function maps(): HasMany
    {
        return $this->hasMany(Map::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Note, $this>
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Organisation, $this>
     */
    public function organisations(): HasMany
    {
        return $this->hasMany(Organisation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Quest, $this>
     */
    public function quests(): HasMany
    {
        return $this->hasMany(Quest::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Ability, $this>
     */
    public function abilities(): HasMany
    {
        return $this->hasMany(Ability::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\AttributeTemplate, $this>
     */
    public function attributeTemplates(): HasMany
    {
        return $this->hasMany(AttributeTemplate::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Tag, $this>
     */
    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Timeline, $this>
     */
    public function timelines(): HasMany
    {
        return $this->hasMany(Timeline::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Bookmark, $this>
     */
    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class)
            ->with(['dashboard']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\DiceRoll, $this>
     */
    public function diceRolls(): HasMany
    {
        return $this->hasMany(DiceRoll::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Conversation, $this>
     */
    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Race, $this>
     */
    public function races(): HasMany
    {
        return $this->hasMany(Race::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Creature, $this>
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\EntityMention, $this>
     */
    public function mentions(): HasMany
    {
        return $this->hasMany('App\Models\EntityMention', 'campaign_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Entity, $this>
     */
    public function entities(): HasMany
    {
        return $this->hasMany(Entity::class, 'campaign_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Theme, $this>
     */
    public function theme(): BelongsTo
    {
        return $this->belongsTo('App\Models\Theme');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Application, $this>
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Relation, $this>
     */
    public function entityRelations(): HasMany
    {
        return $this->hasMany('App\Models\Relation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough<\App\Models\Post, \App\Models\Entity, $this>
     */
    public function posts(): HasManyThrough
    {
        return $this->hasManyThrough(Post::class, Entity::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\Plugin, $this>
     */
    public function plugins(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Plugin', 'campaign_plugins', 'campaign_id', 'plugin_id')
            // ->using('App\Models\CampaignPlugin')
            ->withPivot('is_active')
            ->withPivot('plugin_version_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\CampaignPlugin, $this>
     */
    public function campaignPlugins(): HasMany
    {
        return $this->hasMany(CampaignPlugin::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\CampaignDashboardWidget, $this>
     */
    public function widgets(): HasMany
    {
        return $this->hasMany(CampaignDashboardWidget::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\CampaignDashboard, $this>
     */
    public function dashboards(): HasMany
    {
        return $this->hasMany(CampaignDashboard::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\CampaignExport, $this>
     */
    public function campaignExports(): HasMany
    {
        return $this->hasMany(CampaignExport::class);
    }

    public function queuedCampaignExports()
    {
        return $this->campaignExports()
            ->whereIn('status', [CampaignExport::STATUS_SCHEDULED, CampaignExport::STATUS_RUNNING]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\CampaignImport, $this>
     */
    public function campaignImports(): HasMany
    {
        return $this->hasMany(CampaignImport::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\CampaignStyle, $this>
     */
    public function styles(): HasMany
    {
        return $this->hasMany(CampaignStyle::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<
     *     \App\Models\User,
     *     $this,
     *     \App\Models\EntityUser
     * >
     */
    public function editingUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'entity_user')
            ->using(EntityUser::class)
            ->withPivot('type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\CampaignInvite, $this>
     */
    public function invites(): HasMany
    {
        return $this->hasMany('App\Models\CampaignInvite');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\Genre, $this>
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\GameSystem, $this>
     */
    public function systems(): BelongsToMany
    {
        return $this->belongsToMany(GameSystem::class, 'campaign_system', 'campaign_id', 'system_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\EntityType, $this>
     */
    public function entityTypes(): HasMany
    {
        return $this->hasMany(EntityType::class);
    }

    /**
     * List of the campaign's flags
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\CampaignFlag, $this>
     */
    public function flags(): HasMany
    {
        return $this->hasMany(CampaignFlag::class, 'campaign_id', 'id');
    }
}
