<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Models\Concerns\LastSync;
use App\Models\Concerns\Orderable;
use App\Models\Concerns\Paginatable;
use App\Models\Concerns\Searchable;
use App\Models\Concerns\Sortable;
use App\Models\Concerns\Copiable;
use App\Models\Scopes\SubEntityScopes;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class MiscModel
 * @package App\Models
 *
 * @property int $id
 * @property int $campaign_id
 * @property string $name
 * @property ?Entity $entity
 * @property string $image
 * @property string $tooltip
 * @property string $header_image
 * @property bool|int $is_private
 * @property string[] $nullableForeignKeys
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @method static self|Builder sort(array $filters, array $defaultOrder = [])
 */
abstract class MiscModel extends Model
{
    use Copiable;
    use LastSync;
    use Orderable;
    use Paginatable;
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

    public function getEntityType(): string|null
    {
        return $this->entityType;
    }

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
            return route($this->entity->entityType->pluralCode() . '.' . $action, [$campaign, $this->id]);
        } catch (Exception $e) {
            return '#';
        }
    }

    /**
     * Create the model's Entity
     */
    public function createEntity(): Entity
    {
        $entity = new Entity();
        $entity->entity_id = $this->id;
        $entity->name = $this->name;
        $entity->campaign_id = $this->campaign_id;
        $entity->type_id = $this->entityTypeId();
        $entity->is_private = $this->isPrivate();
        $entity->save();
        $this->setRelation('entity', $entity);

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
     * To be overwritten by the model instance
     */
    public function showProfileInfo(): bool
    {
        return !empty($this->entity->type);
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

    public function isPrivate(): bool
    {
        return (bool) $this->is_private;
    }
}
