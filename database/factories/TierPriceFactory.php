<?php

namespace Database\Factories;

use App\Enums\PricingPeriod;
use App\Models\Tier;
use App\Models\TierPrice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TierPrice>
 */
class TierPriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tier_id' => Tier::factory(),
            'currency' => 'eur',
            'cost' => fake()->randomFloat(2, 1, 250),
            'period' => PricingPeriod::Monthly,
            'stripe_id' => 'price_' . fake()->unique()->lexify('????????????????'),
            'is_active' => true,
            'pricing_version' => null,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn () => ['is_active' => false]);
    }
}
