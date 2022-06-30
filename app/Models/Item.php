<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Models\Concerns\Acl;
use App\Models\Concerns\SortableTrait;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Item
 * @package App\Models
 *
 * @property string $type
 * @property string $price
 * @property string $size
 * @property string $weight
 * @property integer $item_id
 * @property integer $character_id
 * @property integer $location_id
 * @property Character $character
 * @property Location $location
 * @property Item[] $items
 * @property Item $item
 */
class Item extends MiscModel
{
    use CampaignTrait,
        ExportableTrait,
        SoftDeletes,
        SortableTrait,
        Acl
    ;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'campaign_id',
        'slug',
        'type',
        'image',
        'entry',
        'price',
        'size',
        'item_id',
        'character_id',
        'location_id',
        'is_private',
    ];
    protected $sortable = [
        'name',
        'type',
        'price',
        'size',
        'item_id',
    ];
    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name', 'type', 'entry', 'price', 'size'];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'item';

    /**
     * Fields that can be sorted on
     * @var array
     */
    protected $sortableColumns = [
        'price',
        'size',
        'location.name',
        'character.name',
        'item_id',
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
     * @var array
     */
    public $nullableForeignKeys = [
        'location_id',
        'character_id',
    ];


    /**
     * Foreign relations to add to export
     * @var array
     */
    protected $foreignExport = [

    ];

    public function tooltip($limit = 250, $stripSpecial = true)
    {
        $tooltip = parent::tooltip($limit, $stripSpecial);

        $extra = [];
        if (!empty($this->price)) {
            $extra[] = __('items.fields.price') . ': ' . htmlentities($this->price);
        }
        if (!empty($this->size)) {
            $extra[] = __('items.fields.size') . ': ' . htmlentities($this->size);
        }
        if (!empty($extra)) {
            $tooltip .= '<br /><p>' . implode('<br />', $extra) . '</p>';
        }

        return $tooltip;
    }

    /**
     * Performance with for datagrids
     * @param $query
     * @return mixed
     */
    public function scopePreparedWith(Builder $query)
    {
        return $query->with([
            'entity',
            'entity.image',
            'location',
            'location.entity',
            'character',
            'character.entity'
        ]);
    }

    /**
     * Only select used fields in datagrids
     * @return array
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
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function items()
    {
        return $this->hasMany('App\Models\Item', 'item_id', 'id');
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
     * @return array
     */
    public function menuItems(array $items = []): array
    {
        $campaign = CampaignLocalization::getCampaign();

        $inventoryCount = $this->inventories()->with('item')->has('entity')->count();
        if ($inventoryCount > 0) {
            $items['second']['inventories'] = [
                'name' => 'items.show.tabs.inventories',
                'route' => 'items.inventories',
                'count' => $inventoryCount
            ];
        }

        return parent::menuItems($items);
    }

    /**
     * Get the entity_type id from the entity_types table
     * @return int
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.item');
    }

    /**
     * Determine if the model has profile data to be displayed
     * @return bool
     */
    public function showProfileInfo(): bool
    {
        if (!empty($this->type) || !empty($this->price) || !empty($this->size)) {
            return true;
        }

        if ($this->character || $this->location) {
            return true;
        }

        return false;
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
        ];
    }
}
