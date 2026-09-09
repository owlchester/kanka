<?php

namespace App\Models;

use App\Enums\PricingPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $code
 * @property string $name
 * @property float $monthly
 * @property float $yearly
 * @property Collection|TierPrice[] $prices
 */
class Tier extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'monthly',
        'yearly',
        'position',
    ];

    /**
     * @return HasMany<TierPrice, $this>
     */
    public function prices(): HasMany
    {
        return $this->hasMany(TierPrice::class);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('position');
    }

    public function isFree(): bool
    {
        return $this->name === Pledge::KOBOLD;
    }

    public function isPopular(): bool
    {
        return $this->name === Pledge::OWLBEAR;
    }

    public function isBestValue(): bool
    {
        return $this->name === Pledge::WYVERN;
    }

    public function image(): string
    {
        return match ($this->name) {
            'Owlbear' => asset('/images/tiers/owlbear-128.png'),
            'Wyvern' => asset('/images/tiers/wyvern-128.png'),
            'Elemental' => asset('/images/tiers/elemental-128.png'),
            default => asset('/images/tiers/kobold-128.png')
        };
    }

    public function isCurrent(User $user): bool
    {
        if ($this->name === Pledge::OWLBEAR && $user->isOwlbear()) {
            return true;
        } elseif ($this->name === Pledge::WYVERN && $user->isWyvern()) {
            return true;
        }

        return (bool) ($this->name === Pledge::ELEMENTAL && $user->isElemental());
    }

    public function monthlyPlans(): array
    {
        return $this->prices
            ->where('period', PricingPeriod::Monthly)
            ->pluck('stripe_id')
            ->all();
    }

    public function yearlyPlans(): array
    {
        return $this->prices
            ->where('period', PricingPeriod::Yearly)
            ->pluck('stripe_id')
            ->all();
    }

    public function plans(): array
    {
        return $this->prices->pluck('stripe_id')->all();
    }

    public function price(string $currency, PricingPeriod $period): float
    {
        $price = $this->activePrice($currency, $period);
        if (empty($price)) {
            return 0.00;
        }

        return $price->cost;
    }

    public function activePrice(string $currency, PricingPeriod $period): ?TierPrice
    {
        return $this->prices
            ->where('currency', $currency)
            ->where('period', $period)
            ->where('is_active', true)
            ->first();
    }

    public function isWyvern(): bool
    {
        return $this->code === 'wyvern';
    }
}
