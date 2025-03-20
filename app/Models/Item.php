<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\HasLocation;
use App\Models\Concerns\Nested;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * Class Item
 *
 * @property string $type
 * @property string $price
 * @property string $size
 * @property string $weight
 * @property ?int $item_id
 * @property ?int $character_id
 * @property ?Character $character
 */
class Item extends MiscModel
{
    use Acl;
    use ExportableTrait;
    use HasCampaign;
    use HasFactory;
    use HasFilters;
    use HasLocation;
    use HasRecursiveRelationships;
    use Nested;
    use Sanitizable;
    use SoftDeletes;
    use SortableTrait;

    protected $fillable = [
        'name',
        'campaign_id',
        'price',
        'size',
        'weight',
        'item_id',
        'character_id',
        'location_id',
        'is_private',
    ];

    /**
     * Entity type
     */
    protected string $entityType = 'item';

    /**
     * Fields that can be sorted on
     */
    protected array $sortableColumns = [
        'price',
        'size',
        'weight',
        'location.name',
        'character.name',
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
        'character_id',
        'item_id',
    ];

    /**
     * Foreign relations to add to export
     */
    protected array $foreignExport = [

    ];

    protected array $exportFields = [
        'base',
        'item_id',
        'price',
        'size',
        'weight',
        'location_id',
        'character_id',
    ];

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

    public function getParentKeyName(): string
    {
        return 'item_id';
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
            'character' => function ($sub) {
                $sub->select('id', 'name');
            },
            'character.entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id');
            },
        ]));
    }

    /**
     * Only select used fields in datagrids
     */
    public function datagridSelectFields(): array
    {
        return ['character_id', 'location_id', 'price', 'size', 'item_id', 'weight'];
    }

    public function character(): BelongsTo
    {
        return $this->belongsTo('App\Models\Character', 'character_id', 'id');
    }

    public function inventories(): HasMany
    {
        return $this->hasMany('App\Models\Inventory', 'item_id');
    }

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
        if ($this->character || $this->location) {
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
            'character_id',
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
