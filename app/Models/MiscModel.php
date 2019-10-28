<?php

namespace App\Models;

use App\Facades\Mentions;
use App\Models\Concerns\Filterable;
use App\Models\Concerns\Orderable;
use App\Models\Concerns\Paginatable;
use App\Models\Concerns\Searchable;
use App\Models\Concerns\Sortable;
use App\Models\Concerns\Tooltip;
use App\Models\Scopes\SubEntityScopes;
use App\Traits\AclTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Exception;

/**
 * Class MiscModel
 * @package App\Models
 *
 * @property integer $id
 * @property integer $campaign_id
 * @property string $name
 * @property string $slug
 * @property Entity $entity
 * @property string $entry
 * @property string $image
 * @property string $tooltip
 * @property string $header_image
 * @property boolean $is_private
 * @property [] $nullableForeignKeys
 * @property Attribute[] $starredAttributes
 * @property Relation[] $starredRelationss
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
abstract class MiscModel extends Model
{
    use Paginatable,
        AclTrait,
        Searchable,
        Orderable,
        Filterable,
        Tooltip,
        Sortable,
        SubEntityScopes;

    /**
     * If set to false, the saving observer in MiscObserver will be skipped
     * @var bool
     */
    public $savingObserver = true;

    /**
     * If set to false, the save observer in MiscObserver will be skipped
     * @var bool
     */
    public $saveObserver = true;

    /**
     * Eloquence trait for easy search
     */
    //use Eloquence;

    /**
     * Entity type
     * @var
     */
    protected $entityType;

    /**
     * Entity image path
     * @var
     */
    public $entityImagePath;

    /**
     * Filterable fields
     * @var array
     */
    protected $filterableColumns = [];

    /**
     * Fields that can be ordered on
     * @var array
     */
    protected $sortableColumns = [];

    /**
     * Casting order for mysql.
     * Ex. ['age' => 'unsigned']
     * @var array
     */
    protected $orderCasting = [];

    /**
     * Explicit fields for filtering.
     * Ex. ['sex']
     * @var array
     */
    protected $explicitFilters = [];

    /**
     * Fields that can be set to null (foreign keys)
     * @var array
     */
    public $nullableForeignKeys = [];

    /**
     * Field used for tooltips
     * @var string
     */
    protected $tooltipField = 'entry';

    /**
     * Default ordering
     * @var string
     */
    protected $defaultOrderField = 'name';
    protected $defaultOrderDirection = 'asc';

    /**
     * Array of our custom model events declared under model property $observables
     * @var array
     */
    protected $observables = [
        'crudSaved',
    ];

    /**
     * Fire an event to the observer to know that the sub entity was saved from the crud
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
     * @return mixed
     */
    public function permissions()
    {
        return CampaignPermission::where('table_name', $this->entity->pluralType())
            ->where('key', 'like', '%_' . $this->id);
    }

    /**
     * Model's relation to a campaign
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id');
    }

    /**
     * Model present on maps
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locationMaps()
    {
        return $this->hasMany('App\Models\MapPoint', 'target_id');
    }

    /**
     * Get the image (or default image) of an entity
     * @param bool $thumb
     * @return string
     */
    public function getImageUrl($thumb = false, $field = 'image')
    {
        if (empty($this->$field)) {
            // Patreons have nicer icons
            if (auth()->check() && auth()->user()->isGoblinPatron()) {
                return asset('/images/defaults/patreon/' . $this->getTable() . ($thumb ? '_thumb' : null) . '.png');
            }
            return asset('/images/defaults/' . $this->getTable() . ($thumb ? '_thumb' : null) . '.jpg');
        } else {
            return Storage::url(($thumb ? str_replace('.', '_thumb.', $this->$field) : $this->$field));
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function entity()
    {
        return $this
            ->hasOne('App\Models\Entity', 'entity_id', 'id')
            ->where('type', $this->entityType);
    }

    /**
     * @return string|null (menu links)
     */
    public function getEntityType()
    {
        return $this->entityType;
    }

    /**
     * @param string $route
     * @return string
     * @throws Exception
     */
    public function getLink($route = 'show')
    {
        try {
            return route($this->entity->pluralType() . '.' . $route, $this->id);
        } catch (Exception $e) {
            return '#';
        }
    }

    /**
     * Detach children entities from this one. This is for the "Move" functionality, to keep a clean data set.
     */
    public function detach()
    {
        // Loop on children attributes and detach.
        $attributes = $this->getAttributes();
        foreach ($attributes as $attribute) {
            if (strpos($attribute, '_id') !== false && $attribute != 'campaign_id') {
                $this->$attribute = null;
            }
        }
        $this->save();
    }

    /**
     * @return bool
     */
    public function hasEntry()
    {
        // If all that's in the entry is two \n, then there is no real content
        return strlen($this->entry) > 2;
    }

    /**
     * @param array $items
     * @return array
     */
    public function menuItems($items = [])
    {
        $mapPoints = $this->entity->targetMapPoints()->count();
        if ($mapPoints > 0) {
            $items['map-points'] = [
                'name' => 'crud.tabs.map-points',
                'route' => $this->entity->pluralType() . '.map-points',
                'count' => $mapPoints
            ];
        }

        // Each entity can have relations
        if (!isset($this->hasRelations) || $this->hasRelations === true) {
            $items['relations'] = [
                'name' => 'crud.tabs.relations',
                'route' => 'entities.relations.index',
                'count' => $this->entity->relationships()->count(),
                'entity' => true,
            ];
        }


        // Each entity can have an inventory
        $items['inventory'] = [
            'name' => 'crud.tabs.inventory',
            'route' => 'entities.inventory',
            'count' => $this->entity->inventories()->count(),
            'entity' => true,
        ];

        return $items;
    }

    /**
     * List of types as suggestions for the type field
     * @return mixed
     */
    public function entityTypeList()
    {
        return $this
            ->groupBy('type')
            ->whereNotNull('type')
            ->orderBy('type', 'ASC')
            ->limit(20)
            ->pluck('type')
            ->all();
    }

    /**
     * @return mixed
     */
    public function entry()
    {
        return Mentions::map($this);
    }

    /**
     * @return mixed
     */
    public function getEntryForEditionAttribute()
    {
        $text = Mentions::edit($this);
        return $text;
    }

    /**
     * Get the entity link with ajax tooltip
     * @param string $textField = 'name'
     * @return string
     */
    public function tooltipedLink(): string
    {
        if (empty($this->entity)) {
            return e($this->name);
        }
        return '<a class="name" data-toggle="tooltip-ajax" data-id="' . $this->entity->id . '"' .
            'data-url="' . route('entities.tooltip', $this->entity->id). '" href="' .
            $this->getLink() . '">' .
            e($this->name) .
            '</a>';
    }

    /**
     * @return string|null
     */
    public function getEntityTooltipAttribute()
    {
        if ($this->entity) {
            return $this->entity->tooltip;
        }
        return null;
    }
}
