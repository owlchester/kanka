<?php

namespace App\Models;

use App\Traits\VisibilityIDTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Inventory
 * @package App\Models
 *
 * @property integer $entity_id
 * @property integer|null $item_id
 * @property integer|null $created_by
 * @property string $name
 * @property integer $amount
 * @property string $position
 * @property string $description
 * @property bool $is_equipped
 * @property bool $copy_item_entry
 * @property Item|null $item
 * @property Entity|null $entity
 */
class Inventory extends Model
{
    use VisibilityIDTrait;

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
        'visibility_id',
        'created_by',
        'is_equipped',
        'copy_item_entry',
    ];

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
    public function scopePositionList(Builder $builder, Campaign $campaign): Builder
    {
        return $builder->groupBy('position')
            ->whereNotNull('position')
            ->leftJoin('entities as e', 'e.id', 'inventories.entity_id')
            ->where('e.campaign_id', $campaign->id)
            ->orderBy('position', 'ASC')
            ->limit(20)
        ;
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
