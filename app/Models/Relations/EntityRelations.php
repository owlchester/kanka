<?php

namespace App\Models\Relations;

use App\Enums\EntityAssetType;
use App\Enums\EntityEventTypes;
use App\Models\Attribute;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Models\CampaignPermission;
use App\Models\CategoryStatus;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\ConversationParticipant;
use App\Models\Entity;
use App\Models\EntityAbility;
use App\Models\EntityAsset;
use App\Models\EntityClaim;
use App\Models\EntityLocation;
use App\Models\EntityLog;
use App\Models\EntitySheet;
use App\Models\EntityTag;
use App\Models\EntityType;
use App\Models\EntityUser;
use App\Models\Image;
use App\Models\Inventory;
use App\Models\Journal;
use App\Models\MapMarker;
use App\Models\MiscModel;
use App\Models\Post;
use App\Models\QuestElement;
use App\Models\Relation;
use App\Models\Reminder;
use App\Models\Tag;
use App\Models\TimelineElement;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
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
 * @property EntityTag[]|Collection $entityTags
 * @property Post[]|Collection $posts
 * @property Inventory[]|Collection $inventories
 * @property EntityAbility[]|Collection $abilities
 * @property EntityLink[]|Collection $links
 * @property CampaignDashboardWidget[]|Collection $widgets
 * @property Attribute[]|Collection $entityAttributes
 * @property EntityLocation[]|Collection $entityLocations
 * @property MiscModel|null $child
 * @property User $updater
 * @property Campaign $campaign
 * @property Attribute[]|Collection $allAttributes
 * @property Attribute[]|Collection $starredAttributes
 * @property Relation[]|Collection $pinnedRelations
 * @property EntityAsset[]|Collection $pinnedFiles
 * @property EntityAsset[]|Collection $pinnedAssets
 * @property EntityAsset[]|Collection $pinnedAliases
 * @property EntityClaim[]|Collection $claims
 * @property Relation[]|Collection $relationships
 * @property Relation[]|Collection $allRelationships
 * @property Reminder[]|Collection $elapsedEvents
 * @property Reminder[]|Collection $calendarDateEvents
 * @property Reminder[]|Collection $reminders
 * @property Reminder|null $calendarDate
 * @property Image|null $image
 * @property Image|null $header
 * @property User[]|Collection $users
 * @property CampaignPermission[]|Collection $permissions
 * @property EntityAsset[]|Collection $aliases
 * @property EntityAsset[]|Collection $assets
 * @property ?Entity $parent
 * @property ?CategoryStatus $status
 */
trait EntityRelations
{
    /**
     * @return BelongsTo<EntityType, $this>
     */
    public function entityType(): BelongsTo
    {
        return $this->belongsTo(EntityType::class, 'type_id');
    }

    /**
     * @return HasMany<Attribute, $this>
     */
    public function attributes(): HasMany
    {
        return $this->hasMany('App\Models\Attribute', 'entity_id', 'id');
    }

    /** @return HasMany<EntitySheet, $this> */
    public function sheets(): HasMany
    {
        return $this->hasMany(EntitySheet::class)->orderBy('sort_order')->orderBy('id');
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
            ->with(['entity' => function ($sub) {
                $sub->select('entities.id', 'entities.name');
            }])
            ->ordered();
    }

    /**
     * @return HasMany<EntityLocation, $this>
     */
    public function entityLocations(): HasMany
    {
        return $this->hasMany(EntityLocation::class, 'entity_id', 'id');
    }

    /**
     * @return HasMany<EntityTag, $this>
     */
    public function entityTags(): HasMany
    {
        return $this->hasMany('App\Models\EntityTag', 'entity_id', 'id');
    }

    /**
     * @return HasMany<Inventory, $this>
     */
    public function inventories(): HasMany
    {
        return $this->hasMany('App\Models\Inventory', 'entity_id');
    }

    /**
     * @return HasMany<TimelineElement, $this>
     */
    public function timelines(): HasMany
    {
        return $this->hasMany('App\Models\TimelineElement', 'entity_id');
    }

    /**
     * @return HasMany<EntityAbility, $this>
     */
    public function abilities(): HasMany
    {
        return $this->hasMany('App\Models\EntityAbility', 'entity_id');
    }

    /**
     * @return HasMany<QuestElement, $this>
     */
    public function quests(): HasMany
    {
        return $this->hasMany('App\Models\QuestElement', 'entity_id');
    }

    /** @return MorphMany<ConversationParticipant, $this> */
    public function conversationParticipants(): MorphMany
    {
        return $this->morphMany(ConversationParticipant::class, 'participant');
    }

    /** @return MorphMany<ConversationMessage, $this> */
    public function conversationMessages(): MorphMany
    {
        return $this->morphMany(ConversationMessage::class, 'participant');
    }

    /** @return Builder<Conversation> */
    public function conversations(): Builder
    {
        $conversationTable = (new Conversation)->getTable();
        $participantTable = (new ConversationParticipant)->getTable();

        return Conversation::query()
            ->join($participantTable, $participantTable . '.conversation_id', '=', $conversationTable . '.id')
            ->where($participantTable . '.participant_id', $this->id)
            ->where($participantTable . '.participant_type', Entity::class)
            ->select($conversationTable . '.*')
            ->distinct();
    }

    /**
     * @return HasMany<CampaignDashboardWidget, $this>
     */
    public function widgets(): HasMany
    {
        return $this->hasMany('App\Models\CampaignDashboardWidget', 'id', 'entity_id');
    }

    /**
     * @return HasMany<Relation, $this>
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
                ->with([
                    'target' => fn ($sub) => $sub->grid(),
                    'target.entityType',
                    'owner' => fn ($sub) => $sub->grid(),
                ])
                ->has('target')
                ->leftJoin('entities as t', 't.id', '=', 'relations.target_id');
    }

    /**
     * @return HasMany<Relation, $this>
     */
    public function targetRelationships(): HasMany
    {
        return $this->hasMany('App\Models\Relation', 'target_id', 'id');
    }

    /**
     * @return HasMany<Post, $this>
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
        return $this->aliases()
            ->where('is_pinned', 1);
    }

    public function aliases(): HasMany
    {
        return $this->assets()
            ->where('type_id', 3);
    }

    /**
     * @return MorphMany<Reminder, $this>
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
     * @return MorphOne<Reminder, $this>
     */
    public function calendarDate(): MorphOne
    {
        return $this->morphOne(Reminder::class, 'remindable')
            ->with('calendar')
            ->has('calendar')
            ->where('type_id', EntityEventTypes::calendarDate);
    }

    public function elapsedEvents(): MorphMany
    {
        return $this->reminders()->with('calendar')->whereNotNull('type_id');
    }

    /**
     * @return MorphMany<EntityLog, $this>
     */
    public function logs(): MorphMany
    {
        return $this->morphMany(EntityLog::class, 'parent');
    }

    /**
     * @return HasMany<CampaignPermission, $this>
     */
    public function permissions(): HasMany
    {
        return $this->hasMany('App\Models\CampaignPermission', 'entity_id', 'id');
    }

    /**
     * @return HasMany<MapMarker, $this>
     */
    public function mapMarkers(): HasMany
    {
        return $this->hasMany('App\Models\MapMarker', 'entity_id', 'id');
    }

    /**
     * @return HasMany<Journal, $this>
     */
    public function authoredJournals(): HasMany
    {
        return $this->hasMany(Journal::class, 'author_id', 'id');
    }

    /**
     * Entity image stored in the gallery
     *
     * @return HasOne<Image, $this>
     */
    public function image(): HasOne
    {
        return $this->hasOne('App\Models\Image', 'id', 'image_uuid');
    }

    /**
     * Header image stored in the gallery
     *
     * @return HasOne<Image, $this>
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
            ->where('type_id', EntityAssetType::link);
    }

    /**
     * @return HasMany<EntityAsset, $this>
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
     * @return BelongsToMany<
     *     User,
     *     $this,
     *     EntityUser
     * >
     */
    public function editingUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(EntityUser::class)
            ->withPivot('type_id');
    }

    /**
     * @return HasMany<EntityClaim, $this>
     */
    public function claims(): HasMany
    {
        return $this->hasMany(EntityClaim::class);
    }

    /**
     * @return BelongsTo<CategoryStatus, $this>
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(CategoryStatus::class, 'status_id');
    }
}
