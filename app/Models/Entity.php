<?php

namespace App\Models;

use App\Facades\Mentions;
use App\Models\Concerns\Picture;
use App\Models\Concerns\Searchable;
use App\Models\Concerns\SimpleSortableTrait;
use App\Models\Scopes\EntityScopes;
use App\Traits\CampaignTrait;
use App\Traits\EntityAclTrait;
use App\Traits\TooltipTrait;
use Illuminate\Database\Eloquent\Model;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

/**
 * Class Entity
 * @package App\Models
 *
 * @property integer $id
 * @property integer $entity_id
 * @property integer $campaign_id
 * @property string $name
 * @property string $type
 * @property integer $created_by
 * @property integer $updated_by
 * @property boolean $is_private
 * @property boolean $is_attributes_private
 * @property string $tooltip
 * @property string $header_image
 * @property Conversation $conversation
 * @property Tag[] $tags
 * @property EntityTag[] $entityTags
 * @property EntityNote[] $notes
 * @property EntityMention[] $mentions
 * @property Inventory[] $inventories
 * @property EntityMention[] $targetMentions
 * @property EntityAbility[] $abilities
 * @property CampaignDashboardWidget[] $widgets
 * @property MiscModel $child
 */
class Entity extends Model
{
    const TYPE_LOCATION = 'location';

    /**
     * @var array
     */
    protected $fillable = [
        'campaign_id',
        'entity_id',
        'name',
        'type',
        'is_private',
        'is_attributes_private',
        'header_image',
    ];

    /**
     * Traits
     */
    use CampaignTrait,
        BlameableTrait,
        EntityAclTrait,
        EntityScopes,
        Searchable,
        TooltipTrait,
        Picture,
        SimpleSortableTrait;

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns = [
        'name'
    ];

    /**
     * Array of our custom model events declared under model property $observables
     * @var array
     */
    protected $observables = [
        'crudSaved',
    ];

    /**
     * True if the user granted themselves permission to read/write when creating the entity
     * @var bool
     */
    public $permissionGrantSelf = false;

    /**
     * Get the child entity
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function child()
    {
        if ($this->type == 'attribute_template') {
            return $this->attributeTemplate();
        } elseif ($this->type == 'dice_roll') {
            return $this->diceRoll();
        }

        return $this->{$this->type}();
    }

    /**
     * @return Entity
     */
    public function reloadChild()
    {
        if ($this->type == 'attribute_template') {
            return $this->load('attributeTemplate');
        } elseif ($this->type == 'dice_roll') {
            return $this->load('diceRoll');
        }

        return $this->load($this->type);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributes()
    {
        return $this->hasMany('App\Models\Attribute', 'entity_id', 'id');
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
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function abilities()
    {
        return $this->hasMany('App\Models\EntityAbility', 'entity_id');
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
     * Fire an event to the observer to know that the entity was saved from the crud
     */
    public function crudSaved()
    {
        $this->fireModelEvent('crudSaved', false);
    }

    /**
     * Create a short name for the interface
     * @return mixed|string
     */
    public function shortName()
    {
        if (strlen($this->name) > 30) {
            return '<span title="' . e($this->name) . '">' . substr(e($this->name), 0, 28) . '...</span>';
        }
        return $this->name;
    }

    /**
     * @return null
     */
    public function tooltip()
    {
        return $this->child ? $this->child->tooltip() : null;
    }

    /**
     * Short tooltip with location name
     * @return mixed
     */
    public function tooltipWithName()
    {
        return $this->child ? $this->child->tooltipWithName(250, $this->tags) : null;
    }

    /**
     * Full tooltip used for ajax calls
     * @return string|null
     */
    public function fullTooltip()
    {
        if (!$this->child) {
            return null;
        }

        //$avatar = '<img class=\'entity-image\' src=\'' . $this->avatar(true) . '\'/>';
        $text = Str::limit($this->child->entry(), 500);
        $text = strip_tags($text);

        if ($this->campaign->boosted()) {
            $boostedTooltip = strip_tags($this->tooltip);
            if (!empty(trim($boostedTooltip))) {
                $text = Mentions::mapEntity($this);
                $text = strip_tags($text);
            }
        }

        $name = '<span class="entity-name">' . $this->child->tooltipName() . '</span>';
        $subtitle = $this->child->tooltipSubtitle();
        if (!empty($subtitle)) {
            $subtitle = "<span class='entity-subtitle'>$subtitle</span>";
        }
        $text = $this->child->tooltipAddTags($text, $this->tags);

        return $name . $subtitle . $text;
    }


    /**
     * @param string $action
     * @return string
     */
    public function url($action = 'show', $tab = null)
    {
        if ($action == 'index') {
            return route($this->pluralType() . '.index');
        }
        if (!empty($tab)) {
            return route($this->pluralType() . '.' . $action, [$this->entity_id, '#' . $tab]);
        }
        return route($this->pluralType() . '.' . $action, $this->entity_id);
    }

    /**
     * @return string
     */
    public function pluralType(): string
    {
//        if ($this->type == 'family') {
//            return 'families';
//        }
//        elseif ($this->type == 'ability') {
//            return 'abilities';
//        }
        return Str::plural($this->type); // . 's';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function relationships()
    {
        return $this->hasMany('App\Models\Relation', 'owner_id', 'id');
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
     * @param $query
     * @return mixed
     */
    public function scopeTop($query)
    {
        return $query
            ->select('*', DB::raw('count(id) as cpt'))
            ->groupBy('type')
            ->orderBy('cpt', 'desc');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeRecentlyModified($query)
    {
        return $query
            ->orderBy('updated_at', 'desc');
    }

    /**
     * Get the entity's type id
     * @return \Illuminate\Config\Repository|mixed
     */
    public function typeId()
    {
        return config('entities.ids.' . $this->type);
    }

    /**
     * @return mixed
     */
    public function starredAttributes()
    {
        return $this->attributes()->stared()->ordered();
    }

    /**
     * @return mixed
     */
    public function starredRelations()
    {
        return $this->relationships()->stared()->ordered();
    }

    /**
     * Get the image (or default image) of an entity
     * @param bool $thumb
     * @return string
     */
    public function getImageUrl($thumb = false, $field = 'header_image'): string
    {
        if (empty($this->$field)) {
            return '';
        }

        return Storage::url(($thumb ? str_replace('.', '_thumb.', $this->$field) : $this->$field));
    }

    /**
     * If an entity has entity files
     * @return bool
     */
    public function hasFiles(): bool
    {
        return $this->type != 'menu_links';
    }
}
