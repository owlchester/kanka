<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\VisibleTrait;

/**
 * Class Item
 * @package App\Models
 *
 * @property string $type
 * @property string $price
 * @property string $size
 * @property integer $character_id
 * @property integer $location_id
 * @property Character $character
 * @property Location $location
 */
class Item extends MiscModel
{
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
        'character_id',
        'location_id',
        'is_private',
    ];

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name', 'type', 'entry', 'price'];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'item';

    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = [
        'name',
        'type',
        'location_id',
        'character_id',
        'tag_id',
        'is_private',
        'price',
        'size',
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
        'quests',
    ];

    /**
     * Traits
     */
    use CampaignTrait;
    use VisibleTrait;
    use ExportableTrait;

    public function tooltip($limit = 250, $stripSpecial = true)
    {
        $tooltip = parent::tooltip($limit, $stripSpecial);

        $extra = [];
        if (!empty($this->price)) {
            $extra[] = __('items.fields.price') . ': ' . $this->price;
        }
        if (!empty($this->size)) {
            $extra[] = __('items.fields.size') . ': ' . $this->size;
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
    public function scopePreparedWith($query)
    {
        return $query->with(['entity', 'location', 'location.entity', 'character', 'character.entity']);
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
    public function quests()
    {
        return $this->hasManyThrough(
            'App\Models\Quest',
            'App\Models\QuestItem',
            'item_id',
            'id',
            'id',
            'quest_id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inventories()
    {
        return $this->hasMany('App\Models\Inventory', 'item_id');
    }

    /**
     * @return array
     */
    public function menuItems($items = [])
    {
        $campaign = $this->campaign;

        $questCount = $this->quests()->acl()->count();
        if ($campaign->enabled('quests') && $questCount > 0) {
            $items['quests'] = [
                'name' => 'items.show.tabs.quests',
                'route' => 'items.quests',
                'count' => $questCount
            ];
        }

        $inventoryCount = $this->inventories()->acl()->count();
        if ($inventoryCount > 0) {
            $items['inventories'] = [
                'name' => 'items.show.tabs.inventories',
                'route' => 'items.inventories',
                'count' => $inventoryCount
            ];
        }

        return parent::menuItems($items);
    }
}
