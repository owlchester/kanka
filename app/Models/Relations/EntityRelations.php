<?php


namespace App\Models\Relations;

use App\Models\Attribute;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Models\CampaignPermission;
use App\Models\Conversation;
use App\Models\EntityAbility;
use App\Models\EntityAlias;
use App\Models\EntityEvent;
use App\Models\EntityLink;
use App\Models\EntityMention;
use App\Models\EntityNote;
use App\Models\EntityTag;
use App\Models\EntityUser;
use App\Models\Image;
use App\Models\Inventory;
use App\Models\Journal;
use App\Models\Map;
use App\Models\MiscModel;
use App\Models\Quest;
use App\Models\Relation;
use App\Models\Tag;
use App\Models\Timeline;
use App\User;

/**
 * Trait EntityRelations
 * @package App\Models\Relations
 *
 * @property Conversation $conversation
 * @property Tag[] $tags
 * @property EntityTag[] $entityTags
 * @property EntityNote[] $notes
 * @property EntityMention[] $mentions
 * @property Inventory[] $inventories
 * @property EntityMention[] $targetMentions
 * @property EntityAbility[] $abilities
 * @property EntityLink[] $links
 * @property CampaignDashboardWidget[] $widgets
 * @property MiscModel $child
 * @property User $updater
 * @property Campaign $campaign
 * @property Map $map
 * @property Timeline $timeline
 * @property Quest $quest
 * @property Attribute[] $starredAttributes
 * @property Relation[] $starredRelations
 * @property Relation[] $relations
 * @property EntityEvent[] $elapsedEvents
 * @property Image $image
 * @property Image $header
 * @property User[] $users
 * @property CampaignPermission[] $permissions
 * @property EntityAlias[] $aliases
 */
trait EntityRelations
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributes()
    {
        return $this->hasMany('App\Models\Attribute', 'entity_id', 'id');
    }

    public function allAttributes()
    {
        return $this->attributes();
    }

    /**
     * Call $entity->entityAttributes to avoid multiple calls to the db
     * @return mixed
     */
    public function entityAttributes()
    {
        return $this->attributes()
            ->with('entity')
            ->ordered()
        ;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributeTemplate()
    {
        return $this->hasOne('App\Models\AttributeTemplate', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ability()
    {
        return $this->hasOne('App\Models\Ability', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function character()
    {
        return $this->hasOne('App\Models\Character', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function diceRoll()
    {
        return $this->hasOne('App\Models\DiceRoll', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function event()
    {
        return $this->hasOne('App\Models\Event', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function family()
    {
        return $this->hasOne('App\Models\Family', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function item()
    {
        return $this->hasOne('App\Models\Item', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function journal()
    {
        return $this->hasOne('App\Models\Journal', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function location()
    {
        return $this->hasOne('App\Models\Location', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function map()
    {
        return $this->hasOne('App\Models\Map', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function note()
    {
        return $this->hasOne('App\Models\Note', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function organisation()
    {
        return $this->hasOne('App\Models\Organisation', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function quest()
    {
        return $this->hasOne('App\Models\Quest', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function calendar()
    {
        return $this->hasOne('App\Models\Calendar', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function tag()
    {
        return $this->hasOne('App\Models\Tag', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
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

    protected $tagsWithEntity = false;

    public function tagsWithEntity()
    {
        if ($this->tagsWithEntity === false) {
            $this->tagsWithEntity = $this->tags()->with('entity')->get();
        }
        return $this->tagsWithEntity;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function timeline()
    {
        return $this->hasOne('App\Models\Timeline', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entityTags()
    {
        return $this->hasMany('App\Models\EntityTag', 'entity_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function inventories()
    {
        return $this->hasMany('App\Models\Inventory', 'entity_id');
    }

    /**
     * @return mixed
     */
    public function timelines()
    {
        return $this->hasMany('App\Models\TimelineElement', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function abilities()
    {
        return $this->hasMany('App\Models\EntityAbility', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function quests()
    {
        return $this->hasMany('App\Models\QuestElement', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function conversation()
    {
        return $this->hasOne('App\Models\Conversation', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function race()
    {
        return $this->hasOne('App\Models\Race', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function widgets()
    {
        return $this->hasMany('App\Models\CampaignDashboardWidget', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function relationships()
    {
        return $this->hasMany('App\Models\Relation', 'owner_id', 'id');
    }

    /**
     * @return mixed
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
            ->acl()
        ;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function targetRelationships()
    {
        return $this->hasMany('App\Models\Relation', 'target_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes()
    {
        return $this->hasMany('App\Models\EntityNote', 'entity_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany('App\Models\EntityFile', 'entity_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany('App\Models\EntityEvent', 'entity_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function elapsedEvents()
    {
        return $this->events()->with('calendar')->whereNotNull('type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany('App\Models\EntityLog', 'entity_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissions()
    {
        return $this->hasMany('App\Models\CampaignPermission', 'entity_id', 'id');
    }

    /**
     * List of entities that mention this entity
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mentions()
    {
        return $this->hasMany('App\Models\EntityMention', 'entity_id', 'id');
    }

    /**
     * List of entities that mention this entity
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function targetMentions()
    {
        return $this->hasMany('App\Models\EntityMention', 'target_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function targetMapPoints()
    {
        return $this->hasMany('App\Models\MapPoint', 'target_entity_id', 'id');
    }

    /**
     * @return mixed
     */
    public function mapMarkers()
    {
        return $this->hasMany('App\Models\MapMarker', 'entity_id', 'id');
    }

    public function authoredJournals()
    {
        return $this->hasMany(Journal::class, 'author_id', 'id');
    }

    /**
     * @return mixed
     */
    public function image()
    {
        return $this->hasOne('App\Models\Image', 'id', 'image_uuid');
    }

    /**
     * @return mixed
     */
    public function header()
    {
        return $this->hasOne('App\Models\Image', 'id', 'header_uuid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function links()
    {
        return $this->hasMany('App\Models\EntityLink', 'entity_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function aliases()
    {
        return $this->hasMany('App\Models\EntityAlias', 'entity_id', 'id');
    }

    /**
     * @return mixed
     */
    public function starredAttributes()
    {
        return $this->entityAttributes->where('is_star', 1);
    }

    /**
     * @return mixed
     */
    public function starredRelations()
    {
        return $this->relationships()
            ->stared()
            ->ordered()
            ->with('target')
            ->has('target')
            ->acl();
    }

    /**
     * @return mixed
     */
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->using(EntityUser::class)
            ->withPivot('type_id');
    }
}
