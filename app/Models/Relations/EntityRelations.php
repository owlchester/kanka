<?php

namespace App\Models\Relations;

use App\Models\Attribute;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Models\CampaignPermission;
use App\Models\Character;
use App\Models\Conversation;
use App\Models\Creature;
use App\Models\Entity;
use App\Models\EntityAbility;
use App\Models\EntityAsset;
use App\Models\EntityEventType;
use App\Models\EntityTag;
use App\Models\EntityType;
use App\Models\EntityUser;
use App\Models\Image;
use App\Models\Inventory;
use App\Models\Journal;
use App\Models\Map;
use App\Models\MiscModel;
use App\Models\Organisation;
use App\Models\Post;
use App\Models\Quest;
use App\Models\Race;
use App\Models\Relation;
use App\Models\Reminder;
use App\Models\Tag;
use App\Models\Timeline;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * Trait EntityRelations
 *
 * @property EntityType $entityType
 * @property Conversation $conversation
 * @property Character $character
 * @property Creature $creature
 * @property Tag[]|Collection $tags
 * @property EntityTag[]|Collection $entityTags
 * @property Post[]|Collection $posts
 * @property Inventory[]|Collection $inventories
 * @property EntityAbility[]|Collection $abilities
 * @property EntityLink[]|Collection $links
 * @property CampaignDashboardWidget[]|Collection $widgets
 * @property Attribute[]|Collection $entityAttributes
 * @property MiscModel|null $child
 * @property User $updater
 * @property Campaign $campaign
 * @property Map $map
 * @property Race $race
 * @property Timeline $timeline
 * @property Quest $quest
 * @property Organisation $organisation
 * @property Attribute[]|Collection $allAttributes
 * @property Attribute[]|Collection $starredAttributes
 * @property Relation[]|Collection $pinnedRelations
 * @property EntityAsset[]|Collection $pinnedFiles
 * @property EntityAsset[]|Collection $pinnedAssets
 * @property Relation[]|Collection $relations
 * @property Reminder[]|Collection $elapsedEvents
 * @property Reminder[]|Collection $calendarDateEvents
 * @property Reminder[]|Collection $reminders
 * @property Reminder|null $calendarDate
 * @property Image|null $image
 * @property Image|null $header
 * @property User[]|Collection $users
 * @property CampaignPermission[]|Collection $permissions
 * @property EntityAlias[]|Collection $aliases
 * @property EntityAsset[]|Collection $assets
 * @property Entity $parent
 */
trait EntityRelations
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\EntityType, $this>
     */
    public function entityType(): BelongsTo
    {
        return $this->belongsTo(EntityType::class, 'type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Attribute, $this>
     */
    public function attributes(): HasMany
    {
        return $this->hasMany('App\Models\Attribute', 'entity_id', 'id');
    }

    public function allAttributes()
    {
        return $this->attributes();
    }

    /**
     * Call $entity->entityAttributes to avoid multiple calls to the db
     */
    public function entityAttributes()
    {
        return $this->attributes()
            ->with('entity')
            ->ordered();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\AttributeTemplate, $this>
     */
    public function attributeTemplate(): HasOne
    {
        return $this->hasOne('App\Models\AttributeTemplate', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Ability, $this>
     */
    public function ability(): HasOne
    {
        return $this->hasOne('App\Models\Ability', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Character, $this>
     */
    public function character(): HasOne
    {
        return $this->hasOne('App\Models\Character', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\DiceRoll, $this>
     */
    public function diceRoll(): HasOne
    {
        return $this->hasOne('App\Models\DiceRoll', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Event, $this>
     */
    public function event(): HasOne
    {
        return $this->hasOne('App\Models\Event', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Family, $this>
     */
    public function family(): HasOne
    {
        return $this->hasOne('App\Models\Family', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Item, $this>
     */
    public function item(): HasOne
    {
        return $this->hasOne('App\Models\Item', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Journal, $this>
     */
    public function journal(): HasOne
    {
        return $this->hasOne('App\Models\Journal', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Location, $this>
     */
    public function location(): HasOne
    {
        return $this->hasOne('App\Models\Location', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Map, $this>
     */
    public function map(): HasOne
    {
        return $this->hasOne('App\Models\Map', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Note, $this>
     */
    public function note(): HasOne
    {
        return $this->hasOne('App\Models\Note', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Organisation, $this>
     */
    public function organisation(): HasOne
    {
        return $this->hasOne('App\Models\Organisation', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Quest, $this>
     */
    public function quest(): HasOne
    {
        return $this->hasOne('App\Models\Quest', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Calendar, $this>
     */
    public function calendar(): HasOne
    {
        return $this->hasOne('App\Models\Calendar', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Tag, $this>
     */
    public function tag(): HasOne
    {
        return $this->hasOne('App\Models\Tag', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Timeline, $this>
     */
    public function timeline(): HasOne
    {
        return $this->hasOne('App\Models\Timeline', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\EntityTag, $this>
     */
    public function entityTags(): HasMany
    {
        return $this->hasMany('App\Models\EntityTag', 'entity_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Inventory, $this>
     */
    public function inventories(): HasMany
    {
        return $this->hasMany('App\Models\Inventory', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\TimelineElement, $this>
     */
    public function timelines(): HasMany
    {
        return $this->hasMany('App\Models\TimelineElement', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\EntityAbility, $this>
     */
    public function abilities(): HasMany
    {
        return $this->hasMany('App\Models\EntityAbility', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\QuestElement, $this>
     */
    public function quests(): HasMany
    {
        return $this->hasMany('App\Models\QuestElement', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Conversation, $this>
     */
    public function conversation(): HasOne
    {
        return $this->hasOne('App\Models\Conversation', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Race, $this>
     */
    public function race(): HasOne
    {
        return $this->hasOne('App\Models\Race', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Creature, $this>
     */
    public function creature(): HasOne
    {
        return $this->hasOne('App\Models\Creature', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\CampaignDashboardWidget, $this>
     */
    public function widgets(): HasMany
    {
        return $this->hasMany('App\Models\CampaignDashboardWidget', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Relation, $this>
     */
    public function relationships(): HasMany
    {
        return $this->hasMany('App\Models\Relation', 'owner_id', 'id');
    }

    public function allRelationships()
    {
        return
            $this
                ->relationships()
                ->select('relations.*')
                ->with(['target', 'target.entityType', 'owner'])
                ->has('target')
                ->leftJoin('entities as t', 't.id', '=', 'relations.target_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Relation, $this>
     */
    public function targetRelationships(): HasMany
    {
        return $this->hasMany('App\Models\Relation', 'target_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Post, $this>
     */
    public function posts(): HasMany
    {
        return $this->hasMany('App\Models\Post', 'entity_id', 'id');
    }

    public function files(): HasMany
    {
        return $this->assets()
            ->where('type_id', 1);
    }

    public function pinnedFiles(): HasMany
    {
        return $this->files()
            ->where('is_pinned', 1)
            ->with('image');
    }

    public function pinnedAliases(): HasMany
    {
        return $this->assets()
            ->where('is_pinned', 1)
            ->where('type_id', 3);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany<\App\Models\Reminder, $this>
     */
    public function reminders(): MorphMany
    {
        return $this->morphMany(Reminder::class, 'remindable');
    }

    /**
     * Calendar Date Events are used by Journals and Quests to link them directly to a calendar
     */
    public function calendarDateEvents(): MorphMany
    {
        return $this->reminders()
            ->with('calendar')
            ->has('calendar')
            ->calendarDate();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne<\App\Models\Reminder, $this>
     */
    public function calendarDate(): MorphOne
    {
        return $this->morphOne(Reminder::class, 'remindable')
            ->with('calendar')
            ->has('calendar')
            ->where('type_id', EntityEventType::CALENDAR_DATE);
    }

    public function elapsedEvents(): MorphMany
    {
        return $this->reminders()->with('calendar')->whereNotNull('type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\EntityLog, $this>
     */
    public function logs(): HasMany
    {
        return $this->hasMany('App\Models\EntityLog', 'entity_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\CampaignPermission, $this>
     */
    public function permissions(): HasMany
    {
        return $this->hasMany('App\Models\CampaignPermission', 'entity_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\MapMarker, $this>
     */
    public function mapMarkers(): HasMany
    {
        return $this->hasMany('App\Models\MapMarker', 'entity_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Journal, $this>
     */
    public function authoredJournals(): HasMany
    {
        return $this->hasMany(Journal::class, 'author_id', 'id');
    }

    /**
     * Entity image stored in the gallery
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Image, $this>
     */
    public function image(): HasOne
    {
        return $this->hasOne('App\Models\Image', 'id', 'image_uuid');
    }

    /**
     * Header image stored in the gallery
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Image, $this>
     */
    public function header(): HasOne
    {
        return $this->hasOne('App\Models\Image', 'id', 'header_uuid');
    }

    /**
     * @return EntityAsset[]|Collection
     */
    public function links()
    {
        return $this->assets
            ->where('type_id', EntityAsset::TYPE_LINK);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\EntityAsset, $this>
     */
    public function assets(): HasMany
    {
        return $this->hasMany(EntityAsset::class, 'entity_id', 'id')
            ->with('image');
    }

    public function starredAttributes()
    {
        return $this->entityAttributes->where('is_pinned', 1);
    }

    public function pinnedRelations(): HasMany
    {
        return $this->relationships()
            ->pinned()
            ->ordered()
            ->with(['target', 'target.image'])
            ->has('target');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<
     *     \App\Models\User,
     *     \App\Models\Entity,,
     *     \App\Models\EntityUser
     * >
     */
    public function editingUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(EntityUser::class)
            ->withPivot('type_id');
    }
}
