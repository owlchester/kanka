<?php

namespace App\Models\Relations;

use App\Models\Attribute;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Models\CampaignPermission;
use App\Models\Character;
use App\Models\Conversation;
use App\Models\Creature;
use App\Models\EntityAbility;
use App\Models\EntityAsset;
use App\Models\EntityEvent;
use App\Models\EntityEventType;
use App\Models\EntityTag;
use App\Models\EntityUser;
use App\Models\Image;
use App\Models\Inventory;
use App\Models\Journal;
use App\Models\Map;
use App\Models\MiscModel;
use App\Models\Post;
use App\Models\Quest;
use App\Models\Race;
use App\Models\Relation;
use App\Models\Tag;
use App\Models\Timeline;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Trait EntityRelations
 * @package App\Models\Relations
 *
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
 * @property Attribute[]|Collection $allAttributes
 * @property Attribute[]|Collection $starredAttributes
 * @property Relation[]|Collection $pinnedRelations
 * @property EntityAsset[]|Collection $pinnedFiles
 * @property EntityAsset[]|Collection $pinnedAssets
 * @property Relation[]|Collection $relations
 * @property EntityEvent[]|Collection $elapsedEvents
 * @property EntityEvent[]|Collection $calendarDateEvents
 * @property EntityEvent[]|Collection $reminders
 * @property EntityEvent|null $calendarDate
 * @property Image|null $image
 * @property Image|null $header
 * @property User[]|Collection $users
 * @property CampaignPermission[]|Collection $permissions
 * @property EntityAlias[]|Collection $aliases
 * @property EntityAsset[]|Collection $assets
 */
trait EntityRelations
{
    /** @var Collection List of tags attached to the entity */
    protected Collection $tagsWithEntity;

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
            ->ordered()
        ;
    }

    public function attributeTemplate(): HasOne
    {
        return $this->hasOne('App\Models\AttributeTemplate', 'id', 'entity_id');
    }

    public function ability(): HasOne
    {
        return $this->hasOne('App\Models\Ability', 'id', 'entity_id');
    }

    public function character(): HasOne
    {
        return $this->hasOne('App\Models\Character', 'id', 'entity_id');
    }

    public function diceRoll(): HasOne
    {
        return $this->hasOne('App\Models\DiceRoll', 'id', 'entity_id');
    }

    public function event(): HasOne
    {
        return $this->hasOne('App\Models\Event', 'id', 'entity_id');
    }

    public function family(): HasOne
    {
        return $this->hasOne('App\Models\Family', 'id', 'entity_id');
    }

    public function item(): HasOne
    {
        return $this->hasOne('App\Models\Item', 'id', 'entity_id');
    }

    public function journal(): HasOne
    {
        return $this->hasOne('App\Models\Journal', 'id', 'entity_id');
    }

    public function location(): HasOne
    {
        return $this->hasOne('App\Models\Location', 'id', 'entity_id');
    }

    public function map(): HasOne
    {
        return $this->hasOne('App\Models\Map', 'id', 'entity_id');
    }

    public function note(): HasOne
    {
        return $this->hasOne('App\Models\Note', 'id', 'entity_id');
    }

    public function organisation(): HasOne
    {
        return $this->hasOne('App\Models\Organisation', 'id', 'entity_id');
    }

    public function quest(): HasOne
    {
        return $this->hasOne('App\Models\Quest', 'id', 'entity_id');
    }

    public function calendar(): HasOne
    {
        return $this->hasOne('App\Models\Calendar', 'id', 'entity_id');
    }

    public function tag(): HasOne
    {
        return $this->hasOne('App\Models\Tag', 'id', 'entity_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            'App\Models\Tag',
            'entity_tags',
            'entity_id',
            'tag_id',
            'id',
            'id'
        );
    }

    /**
     * @return Collection|Tag[]
     */
    public function tagsWithEntity(bool $excludeHidden = false): Collection
    {
        if (!isset($this->tagsWithEntity)) {
            $this->tagsWithEntity = $this->tags()
                ->with('entity')
                ->has('entity')
                ->get();
        }
        if (!$excludeHidden) {
            return $this->tagsWithEntity->where('is_hidden', '=', '0');
        }
        return $this->tagsWithEntity;
    }

    public function timeline(): HasOne
    {
        return $this->hasOne('App\Models\Timeline', 'id', 'entity_id');
    }

    public function entityTags(): HasMany
    {
        return $this->hasMany('App\Models\EntityTag', 'entity_id', 'id');
    }

    public function inventories(): HasMany
    {
        return $this->hasMany('App\Models\Inventory', 'entity_id');
    }

    public function timelines(): HasMany
    {
        return $this->hasMany('App\Models\TimelineElement', 'entity_id');
    }

    public function abilities(): HasMany
    {
        return $this->hasMany('App\Models\EntityAbility', 'entity_id');
    }

    public function quests(): HasMany
    {
        return $this->hasMany('App\Models\QuestElement', 'entity_id');
    }

    public function conversation(): HasOne
    {
        return $this->hasOne('App\Models\Conversation', 'id', 'entity_id');
    }

    public function race(): HasOne
    {
        return $this->hasOne('App\Models\Race', 'id', 'entity_id');
    }

    public function creature(): HasOne
    {
        return $this->hasOne('App\Models\Creature', 'id', 'entity_id');
    }

    public function widgets(): HasMany
    {
        return $this->hasMany('App\Models\CampaignDashboardWidget', 'id', 'entity_id');
    }

    public function relationships(): HasMany
    {
        return $this->hasMany('App\Models\Relation', 'owner_id', 'id');
    }

    /**
     */
    public function allRelationships()
    {
        return
            $this
                ->relationships()
                ->select('relations.*')
                ->with('target')
                ->has('target')
                ->leftJoin('entities as t', 't.id', '=', 'relations.target_id')
        ;
    }

    public function targetRelationships(): HasMany
    {
        return $this->hasMany('App\Models\Relation', 'target_id', 'id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany('App\Models\Post', 'entity_id', 'id');
    }

    public function files(): HasMany
    {
        return $this->assets()
            ->where('type_id', 1)
        ;
    }

    public function pinnedFiles(): HasMany
    {
        return $this->files()
            ->where('is_pinned', 1)
            ->with('image')
        ;
    }

    public function pinnedAliases(): HasMany
    {
        return $this->assets()
            ->where('is_pinned', 1)
            ->where('type_id', 3)
        ;
    }

    public function events(): HasMany
    {
        return $this->hasMany('App\Models\EntityEvent', 'entity_id', 'id');
    }
    public function reminders(): HasMany
    {
        return $this->hasMany('App\Models\EntityEvent', 'entity_id', 'id');
    }

    /**
     * Calendar Date Events are used by Journals and Quests to link them directly to a calendar
     */
    public function calendarDateEvents(): HasMany
    {
        return $this->reminders()
            ->with('calendar')
            ->has('calendar')
            ->calendarDate();
    }

    public function calendarDate(): HasOne
    {
        return $this->hasOne('App\Models\EntityEvent', 'entity_id', 'id')
            ->with('calendar')
            ->has('calendar')
            ->where('type_id', EntityEventType::CALENDAR_DATE);
    }

    public function elapsedEvents(): HasMany
    {
        return $this->reminders()->with('calendar')->whereNotNull('type_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany('App\Models\EntityLog', 'entity_id', 'id');
    }

    public function permissions(): HasMany
    {
        return $this->hasMany('App\Models\CampaignPermission', 'entity_id', 'id');
    }


    public function mapMarkers(): HasMany
    {
        return $this->hasMany('App\Models\MapMarker', 'entity_id', 'id');
    }

    public function authoredJournals(): HasMany
    {
        return $this->hasMany(Journal::class, 'author_id', 'id');
    }

    /**
     * Entity image stored in the gallery
     */
    public function image(): HasOne
    {
        return $this->hasOne('App\Models\Image', 'id', 'image_uuid');
    }

    /**
     * Header image stored in the gallery
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

    public function assets(): HasMany
    {
        return $this->hasMany(EntityAsset::class, 'entity_id', 'id');
    }

    /**
     */
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

    public function editingUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(EntityUser::class)
            ->withPivot('type_id');
    }
}
