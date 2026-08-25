<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $entity_id
 * @property int $user_id
 * @property Carbon $claimed_at
 * @property ?Carbon $unclaimed_at
 * @property Entity $entity
 * @property User $user
 */
class EntityClaim extends Model
{
    use HasUser;

    public $timestamps = false;

    protected $fillable = [
        'entity_id',
        'user_id',
        'claimed_at',
        'unclaimed_at',
    ];

    protected function casts(): array
    {
        return [
            'claimed_at' => 'datetime',
            'unclaimed_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<Entity, $this>
     */
    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }
}
