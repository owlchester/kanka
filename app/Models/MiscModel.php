<?php

namespace App\Models;

use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Facades\Img;
use App\Facades\Mentions;
use App\Facades\Module;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\LastSync;
use App\Models\Concerns\Orderable;
use App\Models\Concerns\Paginatable;
use App\Models\Concerns\Searchable;
use App\Models\Concerns\Sortable;
use App\Models\Scopes\SubEntityScopes;
use App\Traits\SourceCopiable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Str;

/**
 * Class MiscModel
 * @package App\Models
 *
 * @property int $id
 * @property int $campaign_id
 * @property string $name
 * @property string $type
 * @property string $slug
 * @property Entity|null $entity
 * @property string $entry
 * @property string $image
 * @property string $tooltip
 * @property string $header_image
 * @property boolean $is_private
 * @property string[] $nullableForeignKeys
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Campaign $campaign
 * @property int $created_by
 * @property int $updated_by
 */
abstract class MiscModel extends Model
{
    use HasFilters;
    use LastSync;
    use Orderable;
    use Paginatable;
    use Searchable;
    //Tooltip,
    use Sortable;
    use SourceCopiable;
    use SubEntityScopes;

    /** @var Entity Performance based entity */
    protected Entity $cachedEntity;

    /**
     * @var string Entity type
     */
    protected string $entityType;

    /**
     * Fields that can be ordered on
     */
    protected array $sortableColumns = [];

    /**
     * Explicit fields for filtering.
     * Ex. ['sex']
     * @var array
     */
    protected $explicitFilters = [];

    /**
     * Fields that can be set to null (foreign keys)
     * @var string[]
     */
    public array $nullableForeignKeys = [];

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
     * Get the thumbnail (or default image) of an entity
     * @param int $width If 0, get the full-sized version
     * @return string
     */
    public function thumbnail(int $width = 40, int $height = null, string $field = 'image')
    {
        $entity = $this->cachedEntity ?? $this->entity;
        if (empty($this->$field) || $entity->$field) {
            return $this->getImageFallback($width);
        }

        $img = Img::resetCrop()
            ->crop($width, (!empty($height) ? $height : $width));


        if (!empty($width)) {
            if (!empty($entity->focus_x) && !empty($entity->focus_y)) {
                $img = $img->focus($entity->focus_x, $entity->focus_y);
            }
        }
        return $img
            ->url($this->$field);
    }

    /**
     * Get the image fallback image
     */
    protected function getImageFallback(int $size = 40): string
    {
        // Campaign could have something set up
        $campaign = CampaignLocalization::getCampaign();

        $entity = $this->cachedEntity ?? $this->entity;
        if (!empty($entity->image)) {
            return $entity->image->getUrl($size, $size);
        } elseif ($campaign->boosted() && Arr::has(CampaignCache::defaultImages(), $this->getEntityType())) {
            return Img::crop($size, $size)->url(CampaignCache::defaultImages()[$this->getEntityType()]);
        } elseif (auth()->check() && auth()->user()->isGoblin()) {
            // Goblins and above have nicer icons
            return '/images/defaults/patreon/' . $this->getTable() . '_thumb.png';
        }

        // Default fallback
        return '/images/defaults/' . $this->getTable() . '_thumb.jpg';
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
     * Deterine of the model has an associated entity (bookmarks don't)
     * @return bool
     */
    public function hasEntityType(): bool
    {
        return isset($this->entityType);
    }

    /**
     * @param string $action = 'show'
     * @throws Exception
     */
    public function getLink(string $action = 'show'): string
    {
        if (empty($this->entity)) {
            return '#';
        }
        try {
            $campaign = CampaignLocalization::getCampaign();
            if (in_array($action, ['show', 'update'])) {
                return route('entities.' . $action, [$campaign, $this->entity]);
            }
            return route($this->entity->pluralType() . '.' . $action, [$campaign, $this->id]);
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
            if (str_contains($attribute, '_id')   && $attribute != 'campaign_id') {
                $this->$attribute = null;
            }
        }
        $this->save();
    }

    /**
     */
    public function hasEntry(): bool
    {
        $excludedTypes = ['dice_roll', 'conversation', 'attribute_template'];
        if (in_array($this->getEntityType(), $excludedTypes)) {
            return false;
        }
        // If all that's in the entry is two \n, then there is no real content
        return mb_strlen($this->entry) > 2;
    }

    /**
     */
    public function menuItems(array $items = []): array
    {
        $campaign = CampaignLocalization::getCampaign();

        $items['first']['story'] = [
            'name' => 'crud.tabs.story',
            'route' => 'entities.show',
            'entity' => true,
            'button' => auth()->check() && auth()->user()->can('update', $this) ? [
                'url' => route('entities.story.reorder', [$campaign, $this->entity->id]),
                'icon' => 'fa-solid fa-arrow-up-arrow-down',
                'tooltip' => __('entities/story.reorder.icon_tooltip'),
            ] : null,
        ];


        // Each entity can have relations
        if (!isset($this->hasRelations) || $this->hasRelations === true) {
            $items['first']['relations'] = [
                'name' => 'crud.tabs.connections',
                'route' => 'entities.relations.index',
                'count' => $this->entity->relationships()->has('target')->count(),
                'entity' => true,
                'icon' => 'fa-solid fa-users',
            ];
        }

        // Each entity can have abilities
        if ($campaign->enabled('abilities') && $this->entityTypeId() != config('entities.ids.ability')) {
            $items['third']['abilities'] = [
                'name' => Module::plural(config('entities.ids.ability'), 'crud.tabs.abilities'),
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

        if ($this->entity->accessAttributes()) {
            $items['third']['attributes'] = [
                'name' => 'crud.tabs.attributes',
                'route' => 'entities.attributes',
                'entity' => true,
                'icon' => '',
            ];
        }

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
        if ($this->entity->hasFiles()) {
            $items['third']['assets'] = [
                'name' => 'crud.tabs.assets',
                'route' => 'entities.entity_assets.index',
                'count' => $this->entity->assets()->filtered($campaign->boosted())->count(),
                'entity' => true,
                'icon' => 'fa-solid fa-file',
            ];
        }

        // Check if and how many times entity has been mentioned
        $mentionsCount = $this->entity->mentionsCount();
        if (auth()->check() && $mentionsCount > 0) {
            $items['fourth']['mentions'] = [
                'name' => 'crud.tabs.mentions',
                'route' => 'entities.mentions',
                'entity' => true,
                'count' => $mentionsCount,
                'icon' => 'fa-solid fa-lock',
            ];
        }

        // Permissions for the admin?
        if (auth()->check() && auth()->user()->can('permission', $this)) {
            $items['fourth']['permissions'] = [
                'name' => 'crud.tabs.permissions',
                'route' => 'entities.permissions',
                'entity' => true,
                'icon' => 'fa-solid fa-lock',
                'ajax' => true,
                'id' => 'entity-permissions-link'
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
            $sortedItems = array_combine(array_keys($items['third']), array_column($items['third'], 'name'));
            foreach ($sortedItems as $key => $item) {
                $sortedItems[$key] = __($item);
            }

            $collator = new \Collator(app()->getLocale());
            $collator->asort($sortedItems);

            $sortedMenuItems = [];
            foreach ($sortedItems as $key => $item) {
                $sortedMenuItems[$key] = $items['third'][$key];
            }

            $menuItems[] = $sortedMenuItems;
        }
        if (Arr::has($items, 'fourth')) {
            $menuItems[] = $items['fourth'];
        }

        return $menuItems;
    }

    /**
     * List of types as suggestions for the type field
     * @param int $take = 20
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
     */
    public function entry()
    {
        return Mentions::map($this);
    }

    /**
     */
    public function getEntryForEditionAttribute()
    {
        $text = Mentions::parseForEdit($this);
        return $text;
    }

    /**
     * Get the entity link with ajax tooltip.
     * When coming from an entity first, call this method on the entity. It avoids some back and worth.
     */
    public function tooltipedLink(string $displayName = null): string
    {
        if (empty($this->entity)) {
            return e($this->name);
        }

        $campaign = CampaignLocalization::getCampaign();
        return '<a class="name" data-toggle="tooltip-ajax" data-id="' . $this->entity->id . '" ' .
            'data-url="' . route('entities.tooltip', [$campaign, $this->entity->id]) . '" href="' .
            $this->getLink() . '">' .
            (!empty($displayName) ? $displayName : $this->name) .
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
     */
    public function touchSilently()
    {
        return static::withoutEvents(function () {
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
            'deleted_at',
            '_lft',
            '_rgt',
        ];
    }

    /**
     * Parse the entity object to the child to avoid multiple db calls
     * @return $this
     */
    public function withEntity(Entity $entity): self
    {
        $this->cachedEntity = $entity;
        return $this;
    }

    /**
     * Copy related elements to new target. Override this in individual models (ex maps)
     */
    public function copyRelatedToTarget(MiscModel $target)
    {
    }

    /**
     * Available datagrid actions
     * @return string[]
     * @throws Exception
     */
    public function datagridActions(Campaign $campaign): array
    {
        $actions = [];

        // Relations & Inventory
        if (!isset($this->hasRelations)) {
            $actions[] = '
                <a href="' . route('entities.relations.index', [$campaign, $this->entity]) . '" class="p-1 hover:bg-base-200 rounded flex items-center gap-2 text-sm">
                    <i class="fa-solid fa-users" aria-hidden="true"></i> ' . __('crud.tabs.connections') . '
                </a>';

            if ($campaign->enabled('inventories')) {
                $actions[] = '
                <a href="' . route('entities.inventory', [$campaign, $this->entity]) . '" class="p-1 hover:bg-base-200 rounded flex items-center gap-2 text-sm text-base-conten" data-name="inventory">
                    <i class="ra ra-round-bottom-flask" aria-hidden="true"></i> ' . __('crud.tabs.inventory') . '
                </a>';
            }
        }


        if (auth()->check() && auth()->user()->can('update', $this)) {
            if (!empty($actions)) {
                $actions[] = '<hr class="m-0" />';
            }
            $actions[] = '
                <a href="' . $this->getLink('edit') . '" class="p-1 hover:bg-base-200 rounded flex items-center gap-2 text-sm text-base-conten" data-name="edit">
                    <i class="fa-solid fa-edit" aria-hidden="true"></i> ' . __('crud.edit') . '
                </a>';
        }

        return $actions;
    }

    /**
     * Generate the entity's body css classes
     */
    public function bodyClasses(?Entity $entity = null): string
    {
        $classes = [
            'kanka-entity-' . $this->entity->id,
            'kanka-entity-' . $this->getEntityType(),
        ];

        if (!empty($this->type)) {
            $classes[] = 'kanka-type-' . Str::slug($this->type);
        }

        if (empty($entity)) {
            $entity = $this->entity;
        }
        foreach ($entity->tagsWithEntity(true) as $tag) {
            $classes[] = 'kanka-tag-' . $tag->id;
            $classes[] = 'kanka-tag-' . $tag->slug;

            if ($tag->tag_id) {
                $classes[] = 'kanka-tag-' . $tag->tag_id;
            }
        }

        // Specific entity flags
        if ($this instanceof Character && $this->is_dead) {
            $classes[] = 'character-dead';
        } elseif ($this instanceof Quest && $this->is_completed) {
            $classes[] = 'quest-completed';
        }

        if ($this->is_private) {
            $classes[] = 'kanka-entity-private';
        }

        // Entity header?
        $campaign = CampaignLocalization::getCampaign();
        $superboosted = $campaign->superboosted();

        if ($campaign->boosted() && $entity->hasHeaderImage($superboosted)) {
            $classes[] = 'entity-with-banner';
        }

        return (string) implode(' ', $classes);
    }

    /**
     * To be overwritten by the model instance
     */
    public function showProfileInfo(): bool
    {
        return !empty($this->type);
    }

    /**
     * Row classes for entities
     */
    public function rowClasses(): string
    {
        if (!$this->is_private) {
            return '';
        }
        return 'entity-private';
    }

    /**
     * Boilerplate
     */
    public function entityTypeId(): int
    {
        return 0;
    }

    /**
     * Boilerplate for sortable columns in the datagrid dropdowns
     */
    public function datagridSortableColumns(): array
    {
        $columns = [
            'name' => __('crud.fields.name'),
            'type' => __('crud.fields.type'),
        ];

        if (auth()->check() && auth()->user()->isAdmin()) {
            $columns['is_private'] = __('crud.fields.is_private');
        }
        return $columns;
    }
}
