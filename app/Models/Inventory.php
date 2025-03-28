<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use App\Models\Concerns\HasVisibility;
use App\Models\Concerns\Sanitizable;
use App\Observers\InventoryObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Inventory
 *
 * @property int $entity_id
 * @property ?int $item_id
 * @property string $name
 * @property int $amount
 * @property string $position
 * @property string $description
 * @property ?string $image_uuid
 * @property bool|int $is_equipped
 * @property bool|int $copy_item_entry
 * @property ?Item $item
 * @property ?Entity $entity
 * @property ?Image $image
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

    protected static function booted()
    {
        if (app()->runningInConsole() && ! app()->runningUnitTests()) {
            return;
        }
        static::observe(InventoryObserver::class);
    }

    public function entity(): BelongsTo
    {
        return $this->belongsTo('App\Models\Entity');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo('App\Models\Item');
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
            ->limit(50);
    }

    /**
     * Get the item name, either custom or attached object
     */
    public function itemName(): string
    {
        if (empty($this->name) && ! empty($this->item)) {
            return $this->item->name;
        }

        return (string) $this->name;
    }

    /**
     * Copy an entity inventory to another target
     */
    public function copyTo(Entity $target, bool $sameCampaign): bool
    {
        $without = $sameCampaign ? ['entity_id'] : ['entity_id', 'item_id', 'image_uuid'];
        $new = $this->replicate($without);
        $new->entity_id = $target->id;
        if ($sameCampaign) {
            return $new->save();
        }
        if (empty($new->name)) {
            return false;
        }

        return $new->save();

    }
}
