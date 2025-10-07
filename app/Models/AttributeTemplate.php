<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\Nested;
use App\Services\Attributes\RandomService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * Class AttributeTemplate
 *
 * @property ?int $attribute_template_id
 * @property ?int $entity_type_id
 * @property EntityType $entityType
 */
class AttributeTemplate extends MiscModel
{
    use Acl;
    use HasCampaign;
    use HasFilters;
    use HasRecursiveRelationships;
    use Nested;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'campaign_id',
        'attribute_template_id',
        'entity_type_id',
        'is_private',
        'is_enabled',
    ];

    /**
     * Searchable fields
     */
    protected array $searchableColumns = ['name'];

    /**
     * Fields that can be sorted on
     */

    /**
     * Fields that can be set to null (foreign keys)
     *
     * @var string[]
     */
    public array $nullableForeignKeys = [
        'attribute_template_id',
        'entity_type_id',
    ];

    /** @var bool Attribute templates don't have inventory, relations or abilities */
    public bool $hasRelations = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\EntityType, $this>
     */
    public function entityType(): BelongsTo
    {
        return $this->belongsTo('App\Models\EntityType', 'entity_type_id', 'id');
    }

    /**
     * Parent ID field for the Node trait
     *
     * @return string
     */
    public function getParentKeyName()
    {
        return 'attribute_template_id';
    }

    /**
     * Performance with for datagrids
     */
    public function scopePreparedSelect(Builder $query): Builder
    {
        return $query
            ->select([$this->getTable() . '.id', $this->getTable() . '.name', $this->getTable() . '.is_private', $this->getTable() . '.is_enabled', 'attribute_template_id', 'entity_type_id']);
    }

    /**
     * Performance with for datagrids
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return parent::scopePreparedWith($query)
            // Redefine the entity with to include an attributes count
            ->with([
                'entityType',
                'entity' => function ($sub) {
                    $sub->select('id', 'name', 'entity_id', 'type_id', 'type', 'image_path', 'image_uuid', 'focus_x', 'focus_y')
                        ->withCount('attributes');
                },
            ]);
    }

    /**
     * Performance with for datagrids
     */
    public function scopeEnabled(Builder $query): Builder
    {
        return $query
            ->where('is_enabled', true);
    }

    /**
     * Apply a template to an entity
     * todo: move to service
     */
    public function apply(Entity $entity, int $startingOrder = 0): int
    {
        $order = $startingOrder;
        $existing = array_values($entity->attributes()->pluck('name')->toArray());

        // If adding to an entity that already has attributes, we need to add the new ones after the existing ones
        $lastOrder = 0;
        if ($startingOrder == 0) {
            $lastExisting = $entity->attributes()->orderByDesc('default_order')->first();
            if (! empty($lastExisting)) {
                $lastOrder = $lastExisting->default_order + 1;
            }
        }

        /** @var RandomService $randomService */
        $randomService = app()->make(RandomService::class);

        /** @var Attribute $attribute */
        foreach ($this->entity->attributes()->orderBy('default_order', 'ASC')->get() as $attribute) {
            // Don't re-create existing attributes.
            if (in_array($attribute->name, $existing)) {
                continue;
            }

            [$type, $value] = $randomService->randomAttribute($attribute->type_id, $attribute->value);

            Attribute::create([
                'entity_id' => $entity->id,
                'name' => $attribute->name,
                'value' => $value,
                'default_order' => $lastOrder + $order,
                'is_private' => $attribute->is_private,
                'is_pinned' => $attribute->isPinned(),
                'type_id' => $type,
            ]);
            $order++;
        }

        // Loop through parents
        /** @var Tag $children */
        foreach ($this->ancestors()->with('entity')->get() as $children) {
            foreach ($children->entity->attributes()->orderBy('default_order', 'ASC')->get() as $attribute) {
                // Don't re-create existing attributes.
                if (in_array($attribute->name, $existing)) {
                    continue;
                }
                [$type, $value] = $randomService->randomAttribute($attribute->type_id, $attribute->value);

                Attribute::create([
                    'entity_id' => $entity->id,
                    'name' => $attribute->name,
                    'value' => $value,
                    'default_order' => $order,
                    'is_private' => $attribute->is_private,
                    'is_pinned' => $attribute->isPinned(),
                    'type_id' => $type,
                ]);
                $order++;
            }
        }

        $entity->touch();

        return $order;
    }

    /**
     * Get the entity_type id from the entity_types table
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.attribute_template');
    }

    /**
     * Determine if the attribute templates has visible (to show on the entity creation _attributes tab) attributes
     */
    public function hasVisibleAttributes(array $names = []): bool
    {
        if (! $this->entity) {
            return false;
        }
        $visible = false;
        foreach ($this->entity->attributes()->get() as $attribute) {
            if (! in_array($attribute->name, $names)) {
                $visible = true;
            }
        }

        return $visible;
    }

    /**
     * Determine if the model has profile data to be displayed
     */
    public function showProfileInfo(): bool
    {
        return (bool) ($this->entityType);
    }

    /**
     * Define the fields unique to this model that can be used on filters
     *
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'attribute_template_id',
            'is_enabled',
        ];
    }

    /**
     * Grid mode sortable fields
     */
    public function datagridSortableColumns(): array
    {
        $columns = [
            'name' => __('crud.fields.name'),
        ];

        if (auth()->check() && auth()->user()->isAdmin()) {
            $columns['is_private'] = __('crud.fields.is_private');
        }

        return $columns;
    }

    public function toSearchableArray()
    {
        if (! $this->entity) {
            return [];
        }

        return [
            'campaign_id' => $this->entity->campaign_id,
            'entity_id' => $this->entity->id,
            'name' => $this->name,
            'type' => 'attribute_template',
        ];
    }

    public function isEnabled(): bool
    {
        return $this->is_enabled;
    }
}
