<?php

namespace App\Models;

use App\Enums\PricingPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $tier_id
 * @property float $cost
 * @property PricingPeriod $period
 * @property string $currency
 * @property string $stripe_id
 * @property bool $is_active
 * @property string|null $pricing_version
 * @property Tier $tier
 *
 * @method static self|Builder stripe(string $id)
 * @method static self|Builder active()
 */
class TierPrice extends Model
{
    use HasFactory;

    protected $attributes = [
        'is_active' => false,
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'period' => PricingPeriod::class,
        ];
    }

    /**
     * @return BelongsTo<Tier, $this>
     */
    public function tier(): BelongsTo
    {
        return $this->belongsTo(Tier::class);
    }

    public function isYearly(): bool
    {
        return $this->period->isYearly();
    }

    public function scopeYearly(Builder $query): Builder
    {
        return $query->where('period', PricingPeriod::Yearly);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeStripe(Builder $query, string $id): Builder
    {
        return $query->where('stripe_id', $id);
    }
}
