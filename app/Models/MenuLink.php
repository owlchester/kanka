<?php

namespace App\Models;

use App\Facades\Dashboard;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\VisibleTrait;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/**
 * Class MenuLink
 * @package App\Models
 *
 * @property integer $campaign_id
 * @property string $name
 * @property string $tab
 * @property string $menu
 * @property string $type
 * @property string $icon
 * @property string $filters
 * @property string $random_entity_type
 * @property integer $position
 * @property integer $dashboard_id
 * @property CampaignDashboard $dashboard
 * @property Entity $target
 * @property boolean $is_private
 * @property array $optionsAllowedKeys
 */
class MenuLink extends MiscModel
{
    /**
     * @var string
     */
    public $table = 'menu_links';

    /**
     * @var array
     */
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
        'options',
    ];

    /**
     * The attributes that should be cast.
     * @var array
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
    public $optionsAllowedKeys = ['is_nested'];

    /**
     *
     */
    use VisibleTrait;
    use CampaignTrait;

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name'];

    /**
     * Nullable values (foreign keys)
     * @var array
     */
    public $nullableForeignKeys = [
        'entity_id',
        'dashboard_id',
    ];

    public $tooltipField = 'name';

    /**
     * Set to false if this entity type doesn't have relations
     * @var bool
     */
    public $hasRelations = false;

    /**
     * Fields that can be sorted on
     * @var array
     */
    public $sortableColumns = [
        'position',
        'menu',
        'tab',
    ];

    /** @var string Default order for lists */
    public $defaultOrderField = 'position';

    /**
     * Performance with for datagrids
     * @param $query
     * @return mixed
     */
    public function scopePreparedWith($query)
    {
        return $query->with([
            'entity',
            'target',
            'dashboard',
        ]);
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
        ];

        if (!empty($this->menu)) {
            if ($this->menu == 'all-members') {
                $parameters['all_members'] = 1;
            }
        }

        if (!empty($this->tab)) {
            $prefix = 'tab_';
            // remove tab_ from the beginning of the string, if it's present
            $tab = '#tab_' . trim((substr($this->tab, 0, strlen($prefix)) == $prefix ?
                    substr($this->tab, strlen($prefix)) : $this->tab), '#');
            $parameters[] = $tab;
        }
        return $parameters;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        if ($this->dashboard) {
            return route('dashboard', ['dashboard' => $this->dashboard_id]);
        }
        return !empty($this->entity_id) ? $this->getEntityRoute() : $this->getIndexRoute();
    }

    /**
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
            if (Str::contains($this->menu, 'inventor')) {
                return route('entities.inventory', $this->target->id);
            }
            elseif (Str::contains($this->menu, 'relation')) {
                return route('entities.relations.index', $this->target->id);
            }
            elseif (Str::contains($this->menu, 'abilit')) {
                return route('entities.entity_abilities.index', $this->target->id);
            }
            elseif (Str::contains($this->menu, 'map_points')) {
                return route('entities.map-markers', $this->target->id);
            } elseif ($this->menu == 'all-members') {
                $menuRoute = $route;
            }
            if (Route::has($menuRoute)) {
                $route = $menuRoute;
            }
        }
        return route($route, $this->getRouteParams());
    }

    /**
     * @return string
     */
    protected function getIndexRoute()
    {
        $filters = $this->filters . '&_clean=true&_from=quicklink';
        $nestedType = (!empty($this->options['is_nested']) && $this->options['is_nested'] ? 'tree' : 'index');
        try {
            return route(Str::plural($this->type) . ".$nestedType", $filters);
        }
        catch (\Exception $e) {
            return '';
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
     * @param $query
     * @return mixed
     */
    public function scopeOrdered($query) {
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
     * @param $query
     * @return mixed
     */
    public function scopeStandardWith($query)
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
     * @return string
     */
    public function randomEntity()
    {
        $entityType = $this->random_entity_type != 'any' ? $this->random_entity_type : null;

        /** @var Entity $entity */
        $entity = \App\Models\Entity::
            type($entityType)
            ->acl()
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
        if (!empty($this->icon)) {
            return e($this->icon);
        } elseif ($this->target) {
            return 'fa fa-arrow-circle-right';
        } elseif ($this->isRandom()) {
            return 'fa fa-question';
        }
        return 'fa fa-th-list';
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
     * Override the tooltiped link for the datagrid
     * @return string
     */
    public function tooltipedLink(string $dislayName = null): string
    {
        return '<a href="' . $this->getLink() . '">' .
            (!empty($displayName) ? $displayName : e($this->name)) .
        '</a>';
    }
}
