<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasEntry;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\Nested;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * Class Item
 * @package App\Models
 *
 * @property string $type
 * @property string $price
 * @property string $size
 * @property string $weight
 * @property int|null $item_id
 * @property int|null $character_id
 * @property int|null $location_id
 * @property Character|null $character
 * @property Location|null $location
 * @property Item[] $items
 * @property Item|null $item
 */
class Item extends MiscModel
{
    use Acl;
    use ExportableTrait;
    use HasCampaign;
    use HasEntry;
    use HasFactory;
    use HasFilters;
    use HasRecursiveRelationships;
    use Nested;
    use Sanitizable;
    use SoftDeletes;
    use SortableTrait;

    protected $fillable = [
        'name',
        'campaign_id',
        'type',
        'entry',
        'price',
        'size',
        'item_id',
        'character_id',
        'location_id',
        'is_private',
    ];

    protected array $sortable = [
        'name',
        'type',
        'price',
        'size',
        'parent.name',
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
        'location.name',
        'character.name',
    ];

    protected array $sanitizable = [
        'name',
        'type',
        'size',
        'price',
    ];

    /**
     * Casting for order by
     * @var array
     */
    protected $orderCasting = [
        'price' => 'unsigned'
    ];

    /**
     * Nullable values (foreign keys)
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
        'location_id',
        'character_id'
    ];

    /**
     * Tooltip subtitle (item price/size)
     */
    public function tooltipSubtitle(): string
    {
        $extra = [];
        if (!empty($this->price)) {
            $extra[] = __('items.fields.price') . ': ' . e($this->price);
        }
        if (!empty($this->size)) {
            $extra[] = __('items.fields.size') . ': ' . e($this->size);
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
     * @return Builder mixed
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return $query->with([
            'entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id', 'image_path', 'image_uuid', 'focus_x', 'focus_y');
            },
            'entity.image' => function ($sub) {
                $sub->select('campaign_id', 'id', 'ext', 'focus_x', 'focus_y');
            },
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
            'items' => function ($sub) {
                $sub->select('id', 'name', 'item_id');
            },
            'parent' => function ($sub) {
                $sub->select('id', 'name');
            },
            'parent.entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id');
            },
            'children' => function ($sub) {
                $sub->select('id', 'item_id');
            }
        ]);
    }

    /**
     * Only select used fields in datagrids
     */
    public function datagridSelectFields(): array
    {
        return ['character_id', 'location_id', 'price', 'size', 'item_id'];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function character()
    {
        return $this->belongsTo('App\Models\Character', 'character_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'location_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itemQuests()
    {
        return $this->hasMany('App\Models\QuestItem', 'item_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inventories()
    {
        return $this->hasMany('App\Models\Inventory', 'item_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function entities()
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany('App\Models\Item', 'item_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->items();
    }

    /**
     * Parent
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'item_id', 'id');
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
        if (!empty($this->type) || !empty($this->price) || !empty($this->size)) {
            return true;
        }

        return (bool) ($this->character || $this->location);
    }

    /**
     * Define the fields unique to this model that can be used on filters
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'location_id',
            'character_id',
            'price',
            'size',
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
        ];

        if (auth()->check() && auth()->user()->isAdmin()) {
            $columns['is_private'] = __('crud.fields.is_private');
        }
        return $columns;
    }
}
