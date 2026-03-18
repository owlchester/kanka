<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\HasLocation;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Item
 *
 * @property string $type
 * @property string $price
 * @property string $size
 * @property string $weight
 * @property ?int $item_id
 */
class Item extends MiscModel
{
    use Acl;
    use ExportableTrait;
    use HasCampaign;
    use HasFactory;
    use HasFilters;
    use HasLocation;
    use Sanitizable;
    use SoftDeletes;
    use SortableTrait;

    protected $fillable = [
        'name',
        'campaign_id',
        'price',
        'size',
        'weight',
        'location_id',
        'is_private',
    ];

    /**
     * Fields that can be sorted on
     */
    protected array $sortableColumns = [
        'price',
        'size',
        'weight',
        'location.name',
    ];

    protected array $sanitizable = [
        'name',
        'size',
        'weight',
        'price',
    ];

    /**
     * Casting for order by
     *
     * @var array
     */
    protected $orderCasting = [
        'price' => 'unsigned',
    ];

    /**
     * Nullable values (foreign keys)
     *
     * @var string[]
     */
    public array $nullableForeignKeys = [
        'location_id',
    ];

    /**
     * Foreign relations to add to export
     */
    protected array $foreignExport = [
        'itemCreators',
    ];

    protected array $exportFields = [
        'base',
        'item_id',
        'price',
        'size',
        'weight',
        'location_id',
    ];

    /**
     * @var string[] Extra relations loaded for the API endpoint
     */
    public array $apiWith = ['itemCreators'];

    /**
     * Tooltip subtitle (item price/size)
     */
    public function tooltipSubtitle(): string
    {
        $extra = [];
        if (! empty($this->price)) {
            $extra[] = __('items.fields.price') . ': ' . e($this->price);
        }
        if (! empty($this->size)) {
            $extra[] = __('items.fields.size') . ': ' . e($this->size);
        }
        if (! empty($this->weight)) {
            $extra[] = __('items.fields.weight') . ': ' . e($this->weight);
        }
        if (empty($extra)) {
            return '';
        }

        return implode('<br />', $extra);
    }

    /**
     * Performance with for datagrids
     *
     * @return Builder mixed
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return parent::scopePreparedWith($query->with([
            'location' => function ($sub) {
                $sub->select('id', 'name');
            },
            'location.entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id');
            },
            'itemCreators.creator' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id');
            },
        ]));
    }

    /**
     * Only select used fields in datagrids
     */
    public function datagridSelectFields(): array
    {
        return ['location_id', 'price', 'size', 'item_id', 'weight'];
    }

    /**
     * @return BelongsToMany<Entity, $this>
     */
    public function creators(): BelongsToMany
    {
        return $this->belongsToMany(Entity::class, 'item_creator', 'item_id', 'creator_id')
            ->orderBy('item_creator.id')
            ->with([
                'entity' => function ($sub) {
                    $sub->select('id', 'name', 'entity_id', 'type_id');
                },
            ]);
    }

    /**
     * @return HasMany<ItemCreator, $this>
     */
    public function itemCreators(): HasMany
    {
        return $this->hasMany(ItemCreator::class, 'item_id')
            ->orderBy('id')
            ->has('creator')
            ->with([
                'creator' => function ($sub) {
                    $sub->select('id', 'name', 'entity_id', 'type_id');
                },
            ]);
    }

    /**
     * @return HasMany<Inventory, $this>
     */
    public function inventories(): HasMany
    {
        return $this->hasMany('App\Models\Inventory', 'item_id');
    }

    /**
     * @return HasManyThrough<Entity, Inventory, $this>
     */
    public function entities(): HasManyThrough
    {
        return $this->hasManyThrough(
            'App\Models\Entity',
            'App\Models\Inventory',
            'item_id',
            'id',
            'id',
            'entity_id'
        );
    }

    /**
     * Get the entity_type id from the entity_types table
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.item');
    }

    /**
     * Determine if the model has profile data to be displayed
     */
    public function showProfileInfo(): bool
    {
        if (! empty($this->price) || ! empty($this->size) || ! empty($this->weight)) {
            return true;
        }
        if ($this->itemCreators->isNotEmpty() || $this->location) {
            return true;
        }

        return parent::showProfileInfo();
    }

    /**
     * Define the fields unique to this model that can be used on filters
     *
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'location_id',
            'creators',
            'price',
            'size',
            'weight',
            'item_id',
            'is_equipped',
        ];
    }

    /**
     * Grid mode sortable fields
     */
    public function datagridSortableColumns(): array
    {
        $columns = [
            'name' => __('crud.fields.name'),
            'type' => __('crud.fields.type'),
            'price' => __('items.fields.price'),
            'size' => __('items.fields.size'),
            'weight' => __('items.fields.weight'),
        ];

        if (auth()->check() && auth()->user()->isAdmin()) {
            $columns['is_private'] = __('crud.fields.is_private');
        }

        return $columns;
    }
}
