<?php

namespace App\Models;

use App\Enums\InteractionLogVisibility;
use App\Models\Concerns\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class InteractionLog extends Model
{
    use Blameable;
    use HasFactory;

    protected $fillable = [
        'player_session_id',
        'entity_id',
        'entity_claim_id',
        'created_by',
        'note',
        'visibility',
    ];

    protected function casts(): array
    {
        return [
            'visibility' => InteractionLogVisibility::class,
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (self $log): void {
            $log->entity_claim_id = PlayerSession::query()
                ->whereKey($log->player_session_id)
                ->value('entity_claim_id');
        });
    }

    /**
     * @return BelongsTo<PlayerSession, $this>
     */
    public function playerSession(): BelongsTo
    {
        return $this->belongsTo(PlayerSession::class);
    }

    /**
     * @return BelongsTo<Entity, $this>
     */
    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

    /**
     * @return BelongsTo<EntityClaim, $this>
     */
    public function entityClaim(): BelongsTo
    {
        return $this->belongsTo(EntityClaim::class);
    }

    public function effectiveVisibility(): InteractionLogVisibility
    {
        $visibilityValue = $this->getAttribute('visibility');
        if ($visibilityValue instanceof InteractionLogVisibility) {
            return $visibilityValue;
        }
        if (is_string($visibilityValue)) {
            return InteractionLogVisibility::tryFrom($visibilityValue)
                ?? InteractionLogVisibility::Shared;
        }

        $settings = DB::table('campaigns')
            ->join('entities', 'entities.campaign_id', '=', 'campaigns.id')
            ->join('entity_claims', 'entity_claims.entity_id', '=', 'entities.id')
            ->where('entity_claims.id', $this->entity_claim_id)
            ->value('campaigns.settings');
        $settings = is_string($settings) ? json_decode($settings, true) : $settings;
        $visibility = is_array($settings)
            ? $settings['player_hub']['interaction_log_visibility'] ?? InteractionLogVisibility::Shared->value
            : InteractionLogVisibility::Shared->value;

        return InteractionLogVisibility::tryFrom($visibility) ?? InteractionLogVisibility::Shared;
    }
}
