<?php

namespace App\Models;

use App\Facades\BookmarkCache;
use App\Facades\CampaignLocalization;
use App\Facades\Dashboard;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\HasSuggestions;
use App\Models\Concerns\LastSync;
use App\Models\Concerns\Orderable;
use App\Models\Concerns\Privatable;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\Searchable;
use App\Models\Concerns\Sortable;
use App\Models\Concerns\Taggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Bookmark
 *
 * @property int $id
 * @property string $name
 * @property ?string $tab
 * @property ?string $menu
 * @property ?string $type
 * @property string $icon
 * @property ?string $filters
 * @property ?string $parent
 * @property string $css
 * @property string $random_entity_type
 * @property int $position
 * @property ?int $dashboard_id
 * @property ?int $entity_id
 * @property ?int $entity_type_id
 * @property array $options
 * @property ?CampaignDashboard $dashboard
 * @property ?EntityType $entityType
 * @property ?EntityType $randomEntityType
 * @property ?Entity $target
 * @property bool|int $is_private
 * @property bool|int $is_active
 * @property array $optionsAllowedKeys
 *
 * @method static self|Builder ordered()
 * @method static self|Builder active()
 */
class Bookmark extends Model
{
    use Blameable;
    use HasCampaign;
    use HasFactory;
    use HasFilters;
    use HasSuggestions;
    use LastSync;
    use Orderable;
    use Privatable;
    use Sanitizable;
    use Searchable;
    use Sortable;
    use Taggable;

    protected $fillable = [
        'campaign_id',
        'entity_id',
        'entity_type_id',
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
     *
     * @var array<string, string>
     */
    protected $casts = [
        'options' => 'array',
    ];

    protected array $sanitizable = [
        'name',
        'icon',
        'css',
    ];

    /**
     * Custom options array key filter
     * Used in the Menu link observer
     */
    public array $optionsAllowedKeys = ['is_nested', 'default_dashboard', 'subview_filter'];

    /**
     * Searchable fields
     */
    protected array $searchableColumns = ['name'];

    /**
     * Nullable values (foreign keys)
     *
     * @var string[]
     */
    public array $nullableForeignKeys = [
        'entity_id',
        'dashboard_id',
    ];

    protected array $apiWith = [
        'target',
    ];

    protected array $suggestions = [
        BookmarkCache::class => 'clearSuggestion',
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
        'is_active',
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
            'entityType',
            'randomEntityType',
            'target',
            'dashboard',
        ]);
    }

    public function scopePreparedSelect(Builder $query): Builder
    {
        return $query;
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Entity, $this>
     */
    public function target(): BelongsTo
    {
        return $this->belongsTo('App\Models\Entity', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Entity, $this>
     */
    public function entity(): BelongsTo
    {
        return $this->belongsTo('App\Models\Entity', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\CampaignDashboard, $this>
     */
    public function dashboard(): BelongsTo
    {
        return $this->belongsTo('App\Models\CampaignDashboard', 'dashboard_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\EntityType, $this>
     */
    public function entityType(): BelongsTo
    {
        return $this->belongsTo(EntityType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\EntityType, $this>
     */
    public function randomEntityType(): BelongsTo
    {
        return $this->belongsTo(EntityType::class, 'random_entity_type');
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
     * Get the entity_type id from the entity_types table.
     * Needed to get custom module name
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.bookmark');
    }

    public function isRandom(): bool
    {
        return ! empty($this->random_entity_type);
    }

    public function isEntity(): bool
    {
        return ! empty($this->entity_id);
    }

    public function isDashboard(): bool
    {
        return ! empty($this->dashboard_id);
    }

    public function isList(): bool
    {
        return ! empty($this->entity_type_id);
    }

    /**
     * Icon HTML class
     */
    public function iconClass(): string
    {
        if (! empty($this->icon)) {
            return e($this->icon);
        } elseif ($this->target) {
            return 'fa-regular fa-arrow-circle-right';
        } elseif ($this->isRandom()) {
            return 'fa-regular fa-question';
        }
        if (! empty($this->entityType->icon)) {
            return $this->entityType->icon;
        }

        return 'fa-regular fa-th-list';
    }

    /**
     * Validate that the user has access to this dashboard
     */
    public function isValidDashboard(): bool
    {
        return Dashboard::campaign($this->campaign)->getDashboard($this->dashboard_id) !== null;
    }

    public function customClass(Campaign $campaign): string
    {
        $class = '';
        $request = request()->get('bookmark');
        if (! empty($request) && $request == $this->id) {
            $class = 'active ';
        }

        if (! $campaign->boosted()) {
            return $class;
        }
        if (empty($this->css)) {
            return $class;
        }

        return (string) $class . $this->css;
    }

    /**
     * Determine if the bookmark is valid
     */
    public function valid(Campaign $campaign): bool
    {
        $this->setRelation('campaign', $campaign);
        if ($this->dashboard) {
            return $campaign->boosted() && $this->isValidDashboard();
        } elseif ($this->target) {
            return true;
        } elseif ($this->entityType) {
            return true;
        }

        return (bool) ($this->isRandom());
    }

    public function activeModule(Campaign $campaign, Entity|EntityType|null $current = null): ?string
    {
        if (empty($current) || request()->has('bookmark')) {
            return null;
        }
        // We have no way of having a bookmark set "just to the custom module", so in cases where the campaign has a
        // bookmark to the module with no filters, and one with, we assume we want the one without filters to be
        // highlighted.
        if (! empty($this->filters)) {
            return null;
        }
        if ($current instanceof EntityType) {
            if ($current->isStandard() || $current->id != $this->entity_type_id) {
                return null;
            }

            return 'active';
        }
        // @phpstan-ignore-next-line
        if (($current instanceof Entity && $current->entityType && $current->entityType->isStandard()) || $current->type_id != $this->entity_type_id) {
            return null;
        }

        return 'active';
    }
}
