<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Facades\Dashboard;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\Privatable;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\Taggable;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/**
 * Class Bookmark
 * @package App\Models
 *
 * @property string $name
 * @property string|null $tab
 * @property string|null $menu
 * @property string|null $type
 * @property string $icon
 * @property string|null $filters
 * @property string|null $parent
 * @property string $css
 * @property string $random_entity_type
 * @property int $position
 * @property int|null $dashboard_id
 * @property int|null $entity_id
 * @property array $options
 * @property CampaignDashboard|null $dashboard
 * @property Entity|null $target
 * @property bool|int $is_private
 * @property bool|int $is_active
 * @property array $optionsAllowedKeys
 *
 * @method static self|Builder ordered()
 * @method static self|Builder active()
 */
class Bookmark extends MiscModel
{
    use HasCampaign;
    use HasFactory;
    use Privatable;
    use Sanitizable;
    use Taggable;

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

    protected array $sanitizable = [
        'name',
        'icon',
        'css'
    ];

    /**
     * Custom options array key filter
     * Used in the Menu link observer
     *
     */
    public array $optionsAllowedKeys = ['is_nested', 'default_dashboard', 'subview_filter'];

    /**
     * Searchable fields
     */
    protected array $searchableColumns  = ['name'];

    /**
     * Nullable values (foreign keys)
     * @var string[]
     */
    public array $nullableForeignKeys = [
        'entity_id',
        'dashboard_id',
    ];

    protected array $apiWith = [
        'target',
    ];

    /**
     * Set to false if this entity type doesn't have relations
     */
    public bool $hasRelations = false;

    /**
     * Fields that can be sorted on
     */
    public array $sortableColumns = [
        'position',
        'menu',
        'tab',
        'is_active'
    ];

    /** @var string Default order for lists */
    public string $defaultOrderField = 'position';

    /**
     * Performance with for datagrids
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
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordering models by default
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->orderBy('position', 'ASC')
            ->orderBy('name', 'ASC');
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id');
    }

    public function target(): BelongsTo
    {
        return $this->belongsTo('App\Models\Entity', 'entity_id');
    }

    public function dashboard(): BelongsTo
    {
        return $this->belongsTo('App\Models\CampaignDashboard', 'dashboard_id');
    }

    /**
     */
    public function getRouteParams(bool $entity): array
    {
        $campaign = CampaignLocalization::getCampaign();
        $parameters = [
            $campaign,
            $entity ? $this->target : $this->target->entity_id,
            'bookmark' => $this->id
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
     * Get the route the bookmark points to
     */
    public function getRoute(): string
    {
        $campaign = CampaignLocalization::getCampaign();
        if ($this->dashboard) {
            $dashboard = $this->dashboard_id;
            if (Arr::get($this->options, 'default_dashboard') === '1') {
                $dashboard = 'default';
            }
            return route('dashboard', [$campaign, 'dashboard' => $dashboard, 'bookmark' => $this->id]);
        } elseif ($this->isRandom()) {
            return route('bookmarks.random', [$campaign, $this->id]);
        }
        return !empty($this->entity_id) ? $this->getEntityRoute() : $this->getIndexRoute();
    }

    /**
     * Generate a route for an entity's overview or subpage
     */
    protected function getEntityRoute(): string
    {
        $campaign = CampaignLocalization::getCampaign();
        $plural = $this->target->pluralType();
        if (empty($plural)) {
            return '';
        }
        $route = 'entities.show';
        $entity = true;
        if (!empty($this->menu)) {
            $menuRoute = $this->target->pluralType() . '.' . $this->menu;
            $entity = false;

            // Inventories use a different url buildup
            $routeOptions = [$campaign, $this->target->id, 'bookmark' => $this->id];
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
            } elseif ($this->menu === 'attributes') {
                return route('entities.attributes', $routeOptions);
            }
            if (Route::has($menuRoute)) {
                $route = $menuRoute;
            }
        }

        return route($route, $this->getRouteParams($entity));
    }

    /**
     * Generate the route for a list of entities
     */
    protected function getIndexRoute(): string
    {
        $filters = $this->filters . '&_clean=true&_from=bookmark&bookmark=' . $this->id;
        $routeName = Str::plural($this->type) . '.index';
        if (!empty($this->options['is_nested']) && $this->options['is_nested'] == '1') {
            $filters .= '&n=1';
        }
        try {
            $campaign = CampaignLocalization::getCampaign();
            return route($routeName, [$campaign, $filters]);
        } catch (Exception $e) {
            return '/invalid';
        }
    }

    /**
     * Override the get link
     */
    public function getLink(string $route = 'show'): string
    {
        $campaign = CampaignLocalization::getCampaign();
        return route('bookmarks.' . $route, [$campaign, $this->id]);
    }

    /**
     * Get the entity_type id from the entity_types table
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.bookmark');
    }

    public function isRandom(): bool
    {
        return !empty($this->random_entity_type);
    }

    public function isEntity(): bool
    {
        return !empty($this->entity_id);
    }

    public function isDashboard(): bool
    {
        return !empty($this->dashboard_id);
    }

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
        $entity = Entity::inTags($this->tags->pluck('id')->toArray())
            ->inTypes($entityTypeID)
            ->whereNotIn('entities.id', Dashboard::excluding())
            ->inRandomOrder()
            ->first();

        if (empty($entity) || empty($entity->child)) {
            return null;
        }

        return $entity->url();
    }

    /**
     * Icon HTML class
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
     */
    public function isValidDashboard(): bool
    {
        return Dashboard::getDashboard($this->dashboard_id) !== null;
    }

    /**
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
     * Determine if the bookmark is valid
     */
    public function valid(Campaign $campaign): bool
    {
        if ($this->dashboard) {
            return $campaign->boosted() && $this->isValidDashboard();
        } elseif ($this->target) {
            return true;
        } elseif ($this->type) {
            return true;
        } return (bool) ($this->isRandom())


        ;
    }
}
