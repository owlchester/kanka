<?php

namespace App\Models;

use App\Models\Concerns\Filterable;
use App\Models\Concerns\Orderable;
use App\Models\Concerns\Paginatable;
use App\Models\Concerns\Searchable;
use App\Models\Scopes\SubEntityScopes;
use App\Traits\AclTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Class MiscModel
 * @package App\Models
 *
 * @property integer $campaign_id
 * @property string $name
 * @property string $slug
 * @property Entity $entity
 * @property string $entry
 * @property string $image
 * @property boolean $is_private
 * @property [] $nullableForeignKeys
 */
abstract class MiscModel extends Model
{
    use Paginatable,
        AclTrait,
        Searchable,
        Orderable,
        Filterable,
        SubEntityScopes;

    /**
     * If set to false, the saving observer in MiscObserver will be skipped
     * @var bool
     */
    public $savingObserver = true;

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
     * Wrapper for short entry
     * @return mixed
     */
    public function tooltip($limit = 250, $stripSpecial = true)
    {
        // Always remove tags. ALWAYS.
        $pureHistory = strip_tags($this->{$this->tooltipField});

        if ($stripSpecial) {
            $pureHistory = str_replace('"', '\'', $pureHistory);
//            $pureHistory = str_replace('&gt;', null, $pureHistory);
//            $pureHistory = str_replace('&lt;', null, $pureHistory);
            //$pureHistory = htmlentities(htmlspecialchars($pureHistory));
        }

        $pureHistory = preg_replace("/\s/ui", ' ', $pureHistory);
        $pureHistory = trim($pureHistory);

        if (!empty($pureHistory)) {
            if (strlen($pureHistory) > $limit) {
                return mb_substr($pureHistory, 0, $limit) . '...';
            }
        }
        return $pureHistory;
    }

    /**
     * Short tooltip with location name
     * @return mixed
     */
    public function tooltipWithName($limit = 250)
    {
        $text = $this->tooltip($limit);

        // e() isn't enough, remove tags too to avoid ><script injections.
        $name = $this->tooltipName();

        if (empty($text)) {
            return $name;
        }
        return '<h4>' . $name . '</h4>' . $text;
    }

    /**
     * Tooltip name
     * @return string
     */
    public function tooltipName(): string
    {
        // e() isn't enough, remove tags too to avoid ><script injections.
        return e(strip_tags($this->name));
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
     * @return mixed
     */
    public function getEntityType()
    {
        return $this->entityType;
    }

    /**
     * @param string $route
     * @return string
     */
    public function getLink($route = 'show')
    {
        return route($this->entity->pluralType() . '.' . $route, $this->id);
    }

    /**
     * @return array
     */
    public function filterableColumns()
    {
        return $this->filterableColumns;
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
        $mapPoints = $this->entity->targetMapPoints()->acl()->count();
        if ($mapPoints > 0) {
            $items['map-points'] = [
                'name' => 'crud.tabs.map-points',
                'route' => $this->entity->pluralType() . '.map-points',
                'count' => $mapPoints
            ];
        }

        // Each entity can have an inventory
        $items['inventory'] = [
            'name' => 'crud.tabs.inventory',
            'route' => 'entities.inventory',
            'count' => $this->entity->inventories()->acl()->count(),
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
        return $this->acl()
            ->groupBy('type')
            ->whereNotNull('type')
            ->orderBy('type', 'ASC')
            ->limit(20)
            ->pluck('type')
            ->all();
    }
}
