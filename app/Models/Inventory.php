<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Traits\VisibilityTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Inventory
 * @package App\Models
 *
 * @property integer $entity_id
 * @property integer $item_id
 * @property string $name
 * @property integer $amount
 * @property string $position
 * @property string $description
 * @property string $visibility
 * @property integer $created_by
 * @property bool $is_equipped
 * @property bool $copy_item_entry
 * @property Item $item
 * @property Entity $entity
 */
class Inventory extends Model
{
    /**
     * Fillable fields
     */
    public $fillable = [
        'entity_id',
        'item_id',
        'name',
        'amount',
        'position',
        'description',
        'visibility',
        'created_by',
        'is_equipped',
        'copy_item_entry',
    ];

    use VisibilityTrait;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entity(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Entity');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Item');
    }

    /**
     * Who created this entry
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    /**
     * List of recently used positions for the form suggestions
     * @return mixed
     */
    public static function positionList()
    {
        $campaign = CampaignLocalization::getCampaign();
        return self::groupBy('position')
            ->whereNotNull('position')
            ->leftJoin('entities as e', 'e.id', 'inventories.entity_id')
            ->where('e.campaign_id', $campaign->id)
            ->orderBy('position', 'ASC')
            ->limit(20)
            ->pluck('position')
            ->all();
    }

    /**
     * @return string
     */
    public function itemName(): string
    {
        if (empty($this->name) && !empty($this->item)) {
            return $this->item->name;
        }
        return (string) $this->name;
    }

    /**
     * Copy an entity inventory to another target
     * @param Entity $target
     */
    public function copyTo(Entity $target)
    {
        $new = $this->replicate(['entity_id']);
        $new->entity_id = $target->id;
        return $new->save();
    }
}
