<?php

namespace App\Models;

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
 * @property string $filters
 * @property integer $position
 * @property Entity $target
 * @property boolean $is_private
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
        'position'
    ];

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
        'entity_id'
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
     * @return array
     */
    public function getRouteParams()
    {
        $parameters = [
            $this->target->entity_id,
        ];

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
        try {
            return route(Str::plural($this->type) . '.index', $filters);
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
}
