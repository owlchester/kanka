<?php

namespace App\Models;

use App\Enums\PricingPeriod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id
 * @property int $tier_id
 * @property float $cost
 * @property PricingPeriod $period
 * @property string $currency
 * @property string $stripe_id
 * @property Tier $tier
 *
 * @method static self|Builder stripe(string $id)
 */
class TierPrice extends Model
{
    use HasFactory;

    public $casts = [
        'period' => PricingPeriod::class,
    ];

    public function tier(): BelongsTo
    {
        return $this->belongsTo(Tier::class);
    }

    public function isYearly(): bool
    {
        return $this->period->isYearly();
    }

    public function scopeStripe(Builder $query, string $id): Builder
    {
        return $query->where('stripe_id', $id);
    }
}
