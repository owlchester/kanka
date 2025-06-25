<?php

namespace App\Models;

use App\Enums\PricingPeriod;
use Illuminate\Database\Eloquent\Builder;
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
    public $fillable = [
        'name',
        'monthly',
        'yearly',
        'position',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\TierPrice, $this>
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
            'Owlbear' => 'https://d3a4xjr8r2ldhu.cloudfront.net/app/tiers/owlbear-128.png',
            'Wyvern' => 'https://d3a4xjr8r2ldhu.cloudfront.net/app/tiers/wyvern-128.png',
            'Elemental' => 'https://d3a4xjr8r2ldhu.cloudfront.net/app/tiers/elemental-128.png',
            default => 'https://d3a4xjr8r2ldhu.cloudfront.net/app/tiers/kobold-128.png'
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
        return config('subscription.' . $this->code . '.monthly');
    }

    public function yearlyPlans(): array
    {
        return config('subscription.' . $this->code . '.yearly');
    }

    public function plans(): array
    {
        return array_merge(
            config('subscription.' . $this->code . '.monthly'),
            config('subscription.' . $this->code . '.yearly'),
        );
    }

    public function price(string $currency, PricingPeriod $period): float
    {
        /** @var TierPrice $price */
        $price = $this->prices
            ->where('currency', $currency)
            ->where('period', $period)
            ->first();
        if (empty($price)) {
            return 0.00;
        }

        return $price->cost;
    }
}
