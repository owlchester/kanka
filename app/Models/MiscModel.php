<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Models\Concerns\HasSuggestions;
use App\Models\Concerns\LastSync;
use App\Models\Concerns\Orderable;
use App\Models\Concerns\Paginatable;
use App\Models\Concerns\Searchable;
use App\Models\Concerns\Sortable;
use App\Models\Concerns\Copiable;
use App\Models\Scopes\SubEntityScopes;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable as Scout;

/**
 * Class MiscModel
 * @package App\Models
 *
 * @property int $id
 * Still keep campaign_id for phpstan
 * @property int $campaign_id
 * @property string $entry
 * @property string $name
 * @property string $type
 * @property Entity|null $entity
 * @property string $image
 * @property string $tooltip
 * @property string $header_image
 * @property bool|int $is_private
 * @property string[] $nullableForeignKeys
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
abstract class MiscModel extends Model
{
    use Copiable;
    use HasSuggestions;
    use LastSync;
    use Orderable;
    use Paginatable;
    use Scout;
    use Searchable;
    use Sortable;
    use SubEntityScopes;

    /** Entity type (character, location) */
    protected string $entityType;

    /**
     * Explicit fields for filtering.
     * Ex. ['sex']
     */
    protected array $explicitFilters = [];

    /**
     * Fields that can be set to null (foreign keys)
     * @var string[]
     */
    public array $nullableForeignKeys = [];

    /**
     * Default ordering
     */
    protected string $defaultOrderField = 'name';
    protected string $defaultOrderDirection = 'asc';

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
     * Every misc model has an attached entity
     * @return HasOne
     */
    public function entity()
    {
        return $this
            ->hasOne('App\Models\Entity', 'entity_id', 'id')
            ->where('type_id', $this->entityTypeID());
    }

    /**
     * Determine if model inheriting miscModel has an actual entity
     */
    public function hasEntity(): bool
    {
        return method_exists($this, 'entityTypeID');
    }

    /**
     * @return string|null (menu links)
     */
    public function getEntityType(): string|null
    {
        return $this->entityType;
    }

    /**
     * Determine if the model has an associated entity type (bookmarks don't)
     */
    public function hasEntityType(): bool
    {
        return isset($this->entityType);
    }

    /**
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
     * Determine if the model has an entry text field
     */
    public function hasEntry(): bool
    {
        if (!method_exists($this, 'parsedEntry')) {
            return false;
        }
        // If all that's in the entry is two \n, then there is no real content
        return mb_strlen($this->entry) > 2;
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
     * Create the model's Entity
     */
    public function createEntity(): Entity
    {
        $entity = Entity::create([
            'entity_id' => $this->id,
            'campaign_id' => $this->campaign_id,
            'is_private' => $this->is_private,
            'name' => $this->name,
            'type_id' => $this->entityTypeId(),
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
     * Available datagrid actions
     * Todo: move this out of the model
     * @throws Exception
     */
    public function datagridActions(Campaign $campaign): array
    {
        $actions = [];

        // Relations & Inventory
        if (!isset($this->hasRelations)) {
            $actions[] = [
                'route' => route('entities.relations.index', [$campaign, $this->entity]),
                'icon' => 'fa-solid fa-users',
                'label' => 'crud.tabs.connections'
            ];

            if ($campaign->enabled('inventories')) {
                $actions[] = [
                    'route' => route('entities.inventory', [$campaign, $this->entity]),
                    'icon' => 'fa-solid fa-gem',
                    'label' => 'crud.tabs.inventory'
                ];
            }
        }


        if (auth()->check() && auth()->user()->can('update', $this)) {
            if (!empty($actions)) {
                $actions[] = null;
            }
            $actions[] = [
                'route' => $this->getLink('edit'),
                'icon' => 'fa-solid fa-edit',
                'label' => 'crud.edit'
            ];
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

        if ($campaign->boosted() && $entity->hasHeaderImage()) {
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

    /**
     * Get the value used to index the model.
     *
     */
    public function getScoutKey()
    {
        return $this->getTable() . '_' . $this->id;
    }

    /**
     * Get the name of the index associated with the model.
     */
    public function searchableAs(): string
    {
        return 'entities';
    }

    protected function makeAllSearchableUsing($query)
    {
        return $query
            ->select([$this->getTable() . '.*', 'entities.id as entity_id'])
            ->leftJoin('entities', function ($join) {
                $join->on('entities.entity_id', $this->getTable() . '.id')
                    ->where('entities.type_id', $this->entityTypeId());
            })
            ->has('entity')
            ->with('entity');
    }

    public function toSearchableArray()
    {
        // Some models like DiceRolls have no entry, so don't go into scout. Other have no entry because they
        // are coming from the quick creator or new mention parser.
        if (!in_array('entry', $this->getFillable()) || !in_array('entry', array_keys($this->getAttributes()))) {
            return [];
        }

        return [
            'campaign_id' => $this->entity->campaign_id,
            'entity_id' => $this->entity->id,
            'name' => $this->name,
            'type'  => $this->type,
            'entry'  => strip_tags($this->entry),
        ];
    }
}
