<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $item_id
 * @property int $creator_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property ?Item $item
 * @property ?Entity $creator
 */
class ItemCreator extends Model
{
    protected $fillable = [
        'item_id',
        'creator_id',
    ];

    public $table = 'item_creator';

    /**
     * @return BelongsTo<Item, $this>
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * @return BelongsTo<Entity, $this>
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(Entity::class, 'creator_id');
    }

    public function exportFields(): array
    {
        return [
            'item_id',
            'creator_id',
        ];
    }
}
