<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlayerSession extends Model
{
    use Blameable;
    use HasFactory;

    protected $fillable = [
        'entity_claim_id',
        'created_by',
        'name',
        'started_at',
        'ended_at',
        'summary',
    ];

    protected function casts(): array
    {
        return [
            'number' => 'integer',
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::deleting(function (self $session): void {
            $session->interactionLogs()->delete();
        });
    }

    /**
     * @return BelongsTo<EntityClaim, $this>
     */
    public function entityClaim(): BelongsTo
    {
        return $this->belongsTo(EntityClaim::class);
    }

    /**
     * @return HasMany<InteractionLog, $this>
     */
    public function interactionLogs(): HasMany
    {
        return $this->hasMany(InteractionLog::class);
    }
}
