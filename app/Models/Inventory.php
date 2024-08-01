<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use App\Models\Concerns\Sanitizable;
use App\Traits\HasVisibility;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Inventory
 * @package App\Models
 *
 * @property int $entity_id
 * @property int|null $item_id
 * @property int|null $created_by
 * @property string $name
 * @property int $amount
 * @property string $position
 * @property string $description
 * @property string|null $image_uuid
 * @property bool $is_equipped
 * @property bool $copy_item_entry
 * @property Item|null $item
 * @property Entity|null $entity
 * @property Image|null $image
 */
class Inventory extends Model
{
    use Blameable;
    use HasVisibility;
    use Sanitizable;

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
        'image_uuid',
    ];

    public $casts = [
        'visibility_id' => \App\Enums\Visibility::class,
    ];

    protected array $sanitizable = [
        'name',
        'position',
        'description',
    ];

    public function entity(): BelongsTo
    {
        return $this->belongsTo('App\Models\Entity');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo('App\Models\Item');
    }

    /**
     * Who created this entry
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function image(): HasOne
    {
        return $this->hasOne('App\Models\Image', 'id', 'image_uuid');
    }

    /**
     * List of recently used positions for the form suggestions
     */
    public function scopePositionList(Builder $builder, Campaign $campaign): Builder
    {
        return $builder->groupBy('position')
            ->whereNotNull('position')
            ->leftJoin('entities as e', 'e.id', 'inventories.entity_id')
            ->where('e.campaign_id', $campaign->id)
            ->orderBy('position', 'ASC')
            ->limit(50)
        ;
    }

    /**
     * Get the item name, either custom or attached object
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
     */
    public function copyTo(Entity $target): bool
    {
        $new = $this->replicate(['entity_id']);
        $new->entity_id = $target->id;
        return $new->save();
    }
}
