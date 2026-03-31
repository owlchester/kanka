<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $category_id
 * @property string $key
 * @property ?string $icon
 * @property int $sort_order
 * @property bool $is_default
 * @property EntityType $entityType
 */
class CategoryStatus extends Model
{
    public $timestamps = false;

    public $fillable = [
        'category_id',
        'key',
        'icon',
        'sort_order',
        'is_default',
    ];

    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<EntityType, $this>
     */
    public function entityType(): BelongsTo
    {
        return $this->belongsTo(EntityType::class, 'category_id');
    }
}
