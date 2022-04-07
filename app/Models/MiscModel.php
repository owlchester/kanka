<?php

namespace App\Models;

use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Facades\Img;
use App\Facades\Mentions;
use App\Models\Concerns\Filterable;
use App\Models\Concerns\LastSync;
use App\Models\Concerns\Orderable;
use App\Models\Concerns\Paginatable;
use App\Models\Concerns\Searchable;
use App\Models\Concerns\Sortable;
use App\Models\Concerns\Tooltip;
use App\Models\Scopes\SubEntityScopes;
use App\Traits\AclTrait;
use App\Traits\SourceCopiable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Support\Str;

/**
 * Class MiscModel
 * @package App\Models
 *
 * @property integer $id
 * @property integer $campaign_id
 * @property string $name
 * @property string $type
 * @property string $slug
 * @property Entity $entity
 * @property string $entry
 * @property string $image
 * @property string $tooltip
 * @property string $header_image
 * @property boolean $is_private
 * @property [] $nullableForeignKeys
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Campaign $campaign
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
        SubEntityScopes,
        SourceCopiable,
        LastSync
    ;

    /**
     * If set to false, the saving observer in MiscObserver will be skipped
     * @var bool
     */
    public $savingObserver = true;

    /**
     * @var bool|Entity Performance based entity
     */
    protected $cachedEntity = false;

    /**
     * @var bool
     */
    public $forceSavedObserver = false;

    /**
     * If set to false, the save observer in MiscObserver will be skipped
     * @var bool
     */
    public $saveObserver = true;

    /**
     * @var bool Define to false to skip the Image upload handling
     */
    public $saveImageObserver = true;

    /**
     * @var string Entity type
     */
    protected $entityType;

    /**
     * @var string Entity image path
     */
    public $entityImagePath;

    /**
     * @var array Filterable fields
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
     * @param int $width = 200
     * @param int $width = null
     * @param string $field = 'image'
     * @return string
     */
    public function getImageUrl(int $width = 400, int $height = null, string $field = 'image')
    {
        if (empty($this->$field)) {
            return $this->getImageFallback($width);
        }

        $img = Img::resetCrop()
            ->crop($width, (!empty($height) ? $height : $width));


        if (!empty($width)) {
            $entity = $this->cachedEntity !== false ? $this->cachedEntity : $this->entity;
            if(!empty($entity->focus_x) && !empty($entity->focus_y)) {
                $img = $img->focus($entity->focus_x, $entity->focus_y);
            }
        }
        return $img
            ->url($this->$field);
    }

    /**
     * Get the original image url (for prod: aws link)
     * @param string $field
     * @return mixed
     */
    public function getOriginalImageUrl(string $field = 'image')
    {
        return Storage::url($this->$field);
    }

    /**
     * Get the image fallback image
     * @param int $width = 400
     * @return string
     */
    protected function getImageFallback(int $width = 400): string
    {
        // Campaign could have something set up
        $campaign = CampaignLocalization::getCampaign();
        // If campaign is empty, we might be calling the api/campaigns of the user.
        if (empty($campaign) && $this instanceof Campaign) {
            CampaignCache::campaign($this);
            $campaign = $this;
        }

        $entity = $this->cachedEntity !== false ? $this->cachedEntity : $this->entity;
        if ($campaign->boosted(true) && !empty($entity->image))  {
            return Img::crop(40, 40)->url($entity->image->path);
        }
        elseif ($campaign->boosted() && Arr::has(CampaignCache::defaultImages(), $this->getEntityType())) {
            return Img::crop(40, 40)->url(CampaignCache::defaultImages()[$this->getEntityType()]['path']);
        }
        // Goblins and above have nicer icons
        elseif (auth()->check() && auth()->user()->isGoblinPatron()) {
            return asset('/images/defaults/patreon/' . $this->getTable() . ($width !== 400 ? '_thumb' : null) . '.png');
        }

        // Default fallback
        return asset('/images/defaults/' . $this->getTable() . ($width !== 400 ? '_thumb' : null) . '.jpg');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function entity()
    {
        return $this
            ->hasOne('App\Models\Entity', 'entity_id', 'id')
            ->where('type_id', $this->entityTypeID());
    }

    /**
     * @return bool
     */
    public function hasEntity(): bool
    {
        return method_exists($this, 'entityTypeID');
    }

    /**
     * @return string|null (menu links)
     */
    public function getEntityType()
    {
        return $this->entityType;
    }

    /**
     * @param string $route = 'show'
     * @return string
     * @throws Exception
     */
    public function getLink(string $route = 'show'): string
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
    public function hasEntry(): bool
    {
        $excludedTypes = ['dice_roll', 'conversation', 'attribute_template'];
        if (in_array($this->getEntityType(), $excludedTypes)) {
            return false;
        }
        // If all that's in the entry is two \n, then there is no real content
        return strlen($this->entry) > 2;
    }

    /**
     * @param array $items
     * @return array
     */
    public function menuItems(array $items = []): array
    {
        $campaign = CampaignLocalization::getCampaign();

        $items['first']['story'] = [
            'name' => 'crud.tabs.story',
            'route' => $this->entity->pluralType() . '.show',
            'button' => auth()->check() && auth()->user()->can('update', $this) ? [
                'url' => route('entities.story.reorder', $this->entity->id),
                'icon' => 'fa fa-cog',
                'tooltip' => __('entities/story.reorder.icon_tooltip'),
            ] : null,
        ];


        // Each entity can have relations
        if (!isset($this->hasRelations) || $this->hasRelations === true) {
            $items['first']['relations'] = [
                'name' => 'crud.tabs.connections',
                'route' => 'entities.relations.index',
                'count' => $this->entity->relationships()->has('target')->acl()->count(),
                'entity' => true,
                'icon' => 'fa fa-users',
            ];
        }

        // Each entity can have abilities
        if ($campaign->enabled('abilities') && $this->entityTypeId() != config('entities.ids.ability')) {
            $items['third']['abilities'] = [
                'name' => 'crud.tabs.abilities',
                'route' => 'entities.entity_abilities.index',
                'count' => 0, //$this->entity->abilities()->has('ability')->count(),
                'entity' => true,
                'icon' => 'ra ra-fire-symbol',
            ];
        }

        if ($campaign->enabled('calendars')) {
            $items['third']['reminders'] = [
                'name' => 'crud.tabs.reminders',
                'route' => 'entities.entity_events.index',
                'count' => 0, //$this->entity->abilities()->has('ability')->count(),
                'entity' => true,
                'icon' => 'ra ra-sun-moon',
            ];
        }

        if ($this->entity->accessAttributes())
        $items['third']['attributes'] = [
            'name' => 'crud.tabs.attributes',
            'route' => 'entities.attributes',
            'entity' => true,
            'icon' => '',
        ];

        // Each entity can have an inventory
        if ($campaign->enabled('inventories')) {
            $items['third']['inventory'] = [
                'name' => 'crud.tabs.inventory',
                'route' => 'entities.inventory',
                'count' => 0, //$this->entity->inventories()->has('item')->count(),
                'entity' => true,
                'icon' => 'ra ra-round-bottom-flask',
            ];
        }


        // Each entity can have assets
        if (config('entities.file_upload') && $this->entity->hasFiles()) {
            $items['third']['assets'] = [
                'name' => 'crud.tabs.assets',
                'route' => 'entities.assets',
                'count' => $this->entity->files()->count() + ($campaign->boosted() ? $this->entity->links->count() : 0),
                'entity' => true,
                'icon' => 'fa fa-file',
            ];
        }

        // Permissions for the admin?
        if (auth()->check() && auth()->user()->can('permission', $this)) {

            $items['fourth']['permissions'] = [
                'name' => 'crud.tabs.permissions',
                'route' => 'entities.permissions',
                'entity' => true,
                'icon' => 'fa fa-lock',
                'ajax' => true
            ];
        }

        //dump($items);
        $menuItems = [];
        if (Arr::has($items, 'first')) {
            $menuItems[] = $items['first'];
        }
        if (Arr::has($items, 'second')) {
            $menuItems[] = $items['second'];
        }
        if (Arr::has($items, 'third')) {
            $menuItems[] = $items['third'];
        }
        if (Arr::has($items, 'fourth')) {
            $menuItems[] = $items['fourth'];
        }

        return $menuItems;
    }

    /**
     * List of types as suggestions for the type field
     * @param int $take = 20
     * @return array
     */
    public function entityTypeSuggestion(int $take = 20): array
    {
        return $this
            ->select(DB::raw('type, MAX(created_at) as cmat'))
            ->groupBy('type')
            ->whereNotNull('type')
            ->orderBy('cmat', 'DESC')
            ->take($take)
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
     * @param string $displayName
     * @return string
     */
    public function tooltipedLink(string $displayName = null): string
    {
        if (empty($this->entity)) {
            return e($this->name);
        }

        return '<a class="name" data-toggle="tooltip-ajax" data-id="' . $this->entity->id . '" ' .
            'data-url="' . route('entities.tooltip', $this->entity->id) . '" href="' .
            $this->getLink() . '">' .
            (!empty($displayName) ? $displayName : e($this->name)) .
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

    /**
     * Get the model's entity image uuid
     * @return string|null
     */
    public function getEntityImageUuidAttribute()
    {
        if ($this->entity) {
            return $this->entity->image_uuid;
        }
        return null;
    }

    /**
     * Create the model's Entity
     * @return Entity
     */
    public function createEntity(): Entity
    {
        $entity = Entity::create([
            'entity_id' => $this->id,
            'campaign_id' => $this->campaign_id,
            'is_private' => $this->is_private,
            'name' => $this->name,
            'type_id' => $this->entityTypeId()
        ]);

        return $entity;
    }

    /**
     * Touch a model (update the timestamps) without any observers/events
     * @return mixed
     */
    public function touchSilently()
    {
        return static::withoutEvents(function() {
            return $this->touch();
        });
    }

    /**
     * Elements ignored in the change logs
     * @return string[]
     */
    public function ignoredLogAttributes(): array
    {
        return [
            'slug',
            'campaign_id',
            'updated_at',
            '_lft',
            '_rgt',
        ];
    }

    /**
     * Parse the entity object to the child to avoid multiple db calls
     * @param Entity $entity
     * @return $this
     */
    public function withEntity(Entity $entity): self
    {
        $this->cachedEntity = $entity;
        return $this;
    }

    /**
     * Copy related elements to new target. Override this in individual models (ex maps)
     * @param MiscModel $target
     */
    public function copyRelatedToTarget(MiscModel $target)
    {

    }

    /**
     * Available datagrid actions
     * @param Campaign $campaign
     * @return string[]
     * @throws Exception
     */
    public function datagridActions(Campaign $campaign): array
    {
        $actions = [];

        // Relations & Inventory
        if (!isset($this->hasRelations)) {
            $actions[] = '<li>
                <a href="' . route('entities.relations.index', $this->entity) . '" class="dropdown-item">
                    <i class="fa fa-users" aria-hidden="true"></i> ' . __('crud.tabs.connections') . '
                </a>
            </li>';

            if ($campaign->enabled('inventories')) {
                $actions[] = '<li>
                <a href="' . route('entities.inventory', $this->entity) . '" class="dropdown-item">
                    <i class="ra ra-round-bottom-flask" aria-hidden="true"></i> ' . __('crud.tabs.inventory') . '
                </a>
            </li>';
            }

            if ($campaign->enabled('abilities') && $this->entityTypeId() != config('entities.ids.ability')) {
                $actions[] = '<li>
                <a href="' . route('entities.entity_abilities.index', $this->entity) . '" class="dropdown-item">
                    <i class="ra ra-fire-symbol" aria-hidden="true"></i> ' . __('crud.tabs.abilities') . '
                </a>
            </li>';
            }
        }


        if (auth()->check() && auth()->user()->can('update', $this)) {
            if (!empty($actions)) {
                $actions[] = '<li class="divider"></li>';
            }
            $actions[] = '<li>
                <a href="' . $this->getLink('edit') . '" class="dropdown-item">
                    <i class="fa fa-edit" aria-hidden="true"></i> ' . __('crud.edit') . '
                </a>
            </li>';
        }

        return $actions;
    }

    /**
     * Generate the entity's body css classes
     * @return string
     */
    public function bodyClasses(): string
    {
        $classes = [
            'kanka-entity-' . $this->entity->id,
            'kanka-entity-' . $this->getEntityType(),
        ];

        if (!empty($this->type)) {
            $classes[] = 'kanka-type-' . Str::slug($this->type);
        }

        foreach ($this->entity->tagsWithEntity() as $tag) {
            $classes[] = 'kanka-tag-' . $tag->id;
            $classes[] = 'kanka-tag-' . $tag->slug;

            if ($tag->tag_id) {
                $classes[] = 'kanka-tag-' . $tag->tag_id;
            }
        }

        // Specific entity flags
        if ($this instanceof Character and $this->is_dead) {
            $classes[] = 'character-dead';
        }
        elseif ($this instanceof Quest and $this->is_completed) {
            $classes[] = 'quest-completed';
        }

        if ($this->is_private) {
            $classes[] = 'kanka-entity-private';
        }

        return (string) implode(' ', $classes);
    }

    /**
     * To be overwritten by the model instance
     * @return bool
     */
    public function showProfileInfo(): bool
    {
        return !empty($this->type);
    }

    /**
     * Row classes for entities
     * @return string
     */
    public function rowClasses(): string
    {
        if (!$this->is_private) {
            return '';
        }
        return 'entity-private';
    }
}
