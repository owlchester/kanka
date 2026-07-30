<?php

namespace App\Models;

use App\Models\Concerns\Copiable;
use App\Models\Concerns\HasEntity;
use App\Models\Concerns\LastSync;
use App\Models\Concerns\Orderable;
use App\Models\Concerns\Paginatable;
use App\Models\Concerns\Searchable;
use App\Models\Concerns\Sortable;
use App\Models\Concerns\TouchSilently;
use App\Models\Scopes\SubEntityScopes;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class MiscModel
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
 *
 * @method static self|Builder sort(array $filters, array $defaultOrder = [])
 */
abstract class MiscModel extends Model
{
    use Copiable;
    use HasEntity;
    use LastSync;
    use Orderable;
    use Paginatable;
    use Searchable;
    use Sortable;
    use SubEntityScopes;
    use TouchSilently;

    /**
     * Explicit fields for filtering.
     * Ex. ['sex']
     */
    protected array $explicitFilters = [];

    /**
     * Fields that can be set to null (foreign keys)
     *
     * @var string[]
     */
    public array $nullableForeignKeys = [];

    /**
     * Default ordering
     */
    protected string $defaultOrderField = 'name';

    protected string $defaultOrderDirection = 'asc';

    protected static function booted(): void
    {
        static::creating(function (self $model): void {
            // Non-admin forms don't expose the privacy field. Treat a null
            // value as the public default rather than persisting null.
            if ($model->is_private === null) {
                $model->is_private = false;
            }
        });
    }

    /**
     * Every misc model has an attached entity
     *
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
     * Create the model's Entity
     */
    public function createEntity(): Entity
    {
        $entity = new Entity;
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
     * Available datagrid actions
     * Todo: move this out of the model
     *
     * @throws Exception
     */
    public function datagridActions(Campaign $campaign): array
    {
        $actions = [];

        // Relations & Inventory
        if (! isset($this->hasRelations)) {
            $actions[] = [
                'route' => route('entities.relations.index', [$campaign, $this->entity]),
                'icon' => 'fa-regular fa-circle-nodes',
                'label' => 'entries/tabs.relations',
            ];

            if ($campaign->enabled('inventories')) {
                $actions[] = [
                    'route' => route('entities.inventory', [$campaign, $this->entity]),
                    'icon' => 'fa-regular fa-gem',
                    'label' => 'crud.tabs.inventory',
                ];
            }
        }

        if (auth()->check() && auth()->user()->can('update', $this->entity)) {
            if (! empty($actions)) {
                $actions[] = null;
            }
            $actions[] = [
                'route' => route('entities.edit', [$campaign, $this->entity]),
                'icon' => 'edit',
                'label' => 'crud.edit',
            ];
        }

        return $actions;
    }

    /**
     * To be overwritten by the model instance
     */
    public function showProfileInfo(): bool
    {
        return ! empty($this->entity->type) || $this->entity->aliases->isNotEmpty();
    }

    /**
     * Row classes for entities
     */
    public function rowClasses(): string
    {
        $classes = [];
        if ($this->is_private) {
            $classes[] = 'entity-private';
        }

        $statusClass = $this->entity->statusClass();
        if ($statusClass !== '') {
            $classes[] = $statusClass;
        }

        return implode(' ', $classes);
    }

    /**
     * Boilerplate
     */
    public function entityTypeId(): int
    {
        return 0;
    }

    public function isPrivate(): bool
    {
        return (bool) $this->is_private;
    }
}
