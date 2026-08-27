<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    /**
     * @return HasMany<PlayerSession, $this>
     */
    public function playerSessions(): HasMany
    {
        return $this->hasMany(PlayerSession::class);
    }

    /**
     * @return HasOne<PlayerSession, $this>
     */
    public function lastPlayedSession(): HasOne
    {
        return $this->hasOne(PlayerSession::class)->latestOfMany('started_at');
    }

    /**
     * @return HasManyThrough<InteractionLog, PlayerSession, $this>
     */
    public function interactionLogs(): HasManyThrough
    {
        return $this->hasManyThrough(
            InteractionLog::class,
            PlayerSession::class,
            'entity_claim_id',
            'player_session_id',
            'id',
            'id',
        );
    }
}
