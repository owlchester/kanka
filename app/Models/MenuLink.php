<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Facades\Dashboard;
use App\Models\Concerns\Privatable;
use App\Models\Concerns\Taggable;
use App\Traits\CampaignTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/**
 * Class MenuLink
 * @package App\Models
 *
 * @property integer $campaign_id
 * @property string $name
 * @property string|null $tab
 * @property string|null $menu
 * @property string|null $type
 * @property string $icon
 * @property string|null $filters
 * @property string|null $parent
 * @property string $css
 * @property string $random_entity_type
 * @property integer $position
 * @property integer|null $dashboard_id
 * @property integer|null $entity_id
 * @property array $options
 * @property CampaignDashboard|null $dashboard
 * @property Entity|null $target
 * @property boolean $is_private
 * @property boolean $is_active
 * @property array $optionsAllowedKeys
 *
 * @method self ordered()
 */
class MenuLink extends MiscModel
{
    use Taggable, CampaignTrait, Privatable;

    /**
     * @var string
     */
    public $table = 'menu_links';

    /** @var string[]  */
    protected $fillable = [
        'campaign_id',
        'entity_id',
        'name',
        'icon',
        'tab',
        'filters',
        'is_private',
        'menu',
        'type',
        'position',
        'random_entity_type',
        'icon',
        'dashboard_id',
        'css',
        'parent',
        'options',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     * @var array<string, string>
     */
    protected $casts = [
        'options' => 'array',
    ];

    /**
     * Custom options array key filter
     * Used in the Menu link observer
     *
     * @var array
     */
    public array $optionsAllowedKeys = ['is_nested', 'default_dashboard', 'subview_filter'];

    /**
     * Searchable fields
     * @var array
     */
    protected array $searchableColumns  = ['name'];

    /**
     * Nullable values (foreign keys)
     * @var string[]
     */
    public $nullableForeignKeys = [
        'entity_id',
        'dashboard_id',
    ];

    /**
     * Set to false if this entity type doesn't have relations
     * @var bool
     */
    public bool $hasRelations = false;

    /**
     * Fields that can be sorted on
     * @var array
     */
    public $sortableColumns = [
        'position',
        'menu',
        'tab',
        'is_active'
    ];

    /** @var string Default order for lists */
    public $defaultOrderField = 'position';

    /**
     * Performance with for datagrids
     * @param Builder $query
     * @return Builder
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return $query->with([
            'entity',
            'target',
            'dashboard',
        ]);
    }

    /**
     * Scope for Active menu links
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function target()
    {
        return $this->belongsTo('App\Models\Entity', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dashboard()
    {
        return $this->belongsTo('App\Models\CampaignDashboard', 'dashboard_id');
    }

    /**
     * @return array
     */
    public function getRouteParams()
    {
        $parameters = [
            $this->target->entity_id,
            'quick-link' => $this->id
        ];

        if (!empty($this->menu)) {
            if ($this->menu == 'all-members') {
                $parameters['all_members'] = 1;
            }
            if (isset($this->options['subview_filter'])) {
                $parameters[] = $this->options['subview_filter'];
            }
        }

        return $parameters;
    }

    /**
     * Get the route the quick link points to
     * @return string
     */
    public function getRoute(): string
    {
        if ($this->dashboard) {
            $dashboard = $this->dashboard_id;
            if (Arr::get($this->options, 'default_dashboard') === '1') {
                $dashboard = 'default';
            }
            return route('dashboard', ['dashboard' => $dashboard, 'quick-link' => $this->id]);
        }
        return !empty($this->entity_id) ? $this->getEntityRoute() : $this->getIndexRoute();
    }

    /**
     * Generate a route for an entity's overview or subpage
     * @return string
     */
    protected function getEntityRoute(): string
    {
        $plural = $this->target->pluralType();
        if (empty($plural)) {
            return '';
        }
        $route = $plural . '.show';
        if (!empty($this->menu)) {
            $menuRoute = $this->target->pluralType() . '.' . $this->menu;

            // Inventories use a different url buildup
            $routeOptions = [$this->target->id, 'quick-link' => $this->id];
            if ($this->menu === 'inventory') {
                return route('entities.inventory', $routeOptions);
            } elseif ($this->menu === 'relations') {
                return route('entities.relations.index', $routeOptions);
            } elseif ($this->menu === 'abilities') {
                return route('entities.entity_abilities.index', $routeOptions);
            } elseif ($this->menu === 'assets') {
                return route('entities.entity_assets.index', $routeOptions);
            } elseif ($this->menu === 'reminders') {
                return route('entities.entity_events.index', $routeOptions);
            }
            if (Route::has($menuRoute)) {
                $route = $menuRoute;
            }
        }

        return route($route, $this->getRouteParams());
    }

    /**
     * Generate the route for a list of entities
     * @return string
     */
    protected function getIndexRoute(): string
    {
        $filters = $this->filters . '&_clean=true&_from=quicklink&quick-link=' . $this->id;
        $nestedType = (!empty($this->options['is_nested']) && $this->options['is_nested'] == '1' ? 'tree' : 'index');

        $routeName = Str::plural($this->type) . ".$nestedType";
        if ($nestedType === 'tree' && !Route::has($routeName)) {
            $routeName = Str::plural($this->type) . '.index';
        }
        try {
            return route($routeName, $filters);
        } catch (\Exception $e) {
            return '/invalid';
        }
    }

    /**
     * Override the get link
     * @param string $route = 'show'
     * @return string
     */
    public function getLink(string $route = 'show'): string
    {
        return route('menu_links.' . $route, $this->id);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->orderBy('position', 'ASC')
            ->orderBy('name', 'ASC');
    }

    /**
     * Get the entity_type id from the entity_types table
     * @return int
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.menu_link');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeStandardWith(Builder $query): Builder
    {
        return $query->with('entity');
    }

    /**
     * @return bool
     */
    public function isRandom(): bool
    {
        return !empty($this->random_entity_type);
    }

    /**
     * @return bool
     */
    public function isEntity(): bool
    {
        return !empty($this->entity_id);
    }

    /**
     * @return bool
     */
    public function isDashboard(): bool
    {
        return !empty($this->dashboard_id);
    }

    /**
     * @return bool
     */
    public function isList(): bool
    {
        return !empty($this->type);
    }

    /**
     */
    public function randomEntity()
    {
        $entityType = $this->random_entity_type != 'any' ? $this->random_entity_type : null;
        $entityTypeID = null;
        if (!empty($entityType)) {
            $entityTypeID = config('entities.ids.' . $entityType);
        }

        /** @var Entity|null $entity */
        $entity = Entity::
            inTags($this->tags->pluck('id')->toArray())
            ->type($entityTypeID)
            ->inRandomOrder()
            ->first();

        if (empty($entity) || empty($entity->child)) {
            return null;
        }

        return $entity->url('show');
    }

    /**
     * Icon HTML class
     * @return string
     */
    public function icon(): string
    {
        $campaign = CampaignLocalization::getCampaign();
        if (!empty($this->icon) && $campaign->boosted()) {
            return e($this->icon);
        } elseif ($this->target) {
            return 'fa-solid fa-arrow-circle-right';
        } elseif ($this->isRandom()) {
            return 'fa-solid fa-question';
        }
        return 'fa-solid fa-th-list';
    }

    /**
     * Validate that the user has access to this dashboard
     * @return bool
     */
    public function isValidDashboard(): bool
    {
        return Dashboard::getDashboard($this->dashboard_id) !== null;
    }

    /**
     * @param Campaign $campaign
     * @return string
     */
    public function customClass(Campaign $campaign): string
    {
        if (!$campaign->boosted()) {
            return '';
        }
        if (empty($this->css)) {
            return '';
        }

        return (string) $this->css;
    }

    /**
     * Override the tooltiped link for the datagrid
     * @param string|null $displayName
     * @return string
     */
    public function tooltipedLink(string $displayName = null): string
    {
        return '<a href="' . $this->getLink() . '">' .
            (!empty($displayName) ? $displayName : e($this->name)) .
        '</a>';
    }
}
