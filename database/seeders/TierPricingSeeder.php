<?php

namespace Database\Seeders;

use App\Enums\PricingPeriod;
use App\Models\Tier;
use App\Models\TierPrice;
use Illuminate\Database\Seeder;

class TierPricingSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        TierPrice::truncate();

        $this->owlbear()->wyvern()->elemental();

    }

    protected function owlbear(): self
    {
        /** @var Tier $tier */
        $tier = Tier::where('name', 'Owlbear')->first();
        foreach (['eur', 'usd'] as $currency) {
            TierPrice::create([
                'currency' => $currency,
                'period' => PricingPeriod::Monthly,
                'cost' => 4.99,
                'tier_id' => $tier->id,
                'stripe_id' => config('subscription.owlbear.' . $currency . '.monthly'),
            ]);
            TierPrice::create([
                'currency' => $currency,
                'period' => PricingPeriod::Yearly,
                'cost' => 49.90,
                'tier_id' => $tier->id,
                'stripe_id' => config('subscription.owlbear.' . $currency . '.yearly'),
            ]);
        }
        TierPrice::create([
            'currency' => 'brl',
            'period' => PricingPeriod::Monthly,
            'cost' => 19.99,
            'tier_id' => $tier->id,
            'stripe_id' => config('subscription.owlbear.brl.monthly'),
        ]);
        TierPrice::create([
            'currency' => 'brl',
            'period' => PricingPeriod::Yearly,
            'cost' => 199.90,
            'tier_id' => $tier->id,
            'stripe_id' => config('subscription.owlbear.brl.yearly'),
        ]);

        return $this;
    }

    protected function wyvern(): self
    {
        /** @var Tier $tier */
        $tier = Tier::where('name', 'Wyvern')->first();
        foreach (['eur', 'usd'] as $currency) {
            TierPrice::create([
                'currency' => $currency,
                'period' => PricingPeriod::Monthly,
                'cost' => 9.99,
                'tier_id' => $tier->id,
                'stripe_id' => config('subscription.wyvern.' . $currency . '.monthly'),
            ]);
            TierPrice::create([
                'currency' => $currency,
                'period' => PricingPeriod::Yearly,
                'cost' => 99.90,
                'tier_id' => $tier->id,
                'stripe_id' => config('subscription.wyvern.' . $currency . '.yearly'),
            ]);
        }
        TierPrice::create([
            'currency' => 'brl',
            'period' => PricingPeriod::Monthly,
            'cost' => 39.99,
            'tier_id' => $tier->id,
            'stripe_id' => config('subscription.wyvern.brl.monthly'),
        ]);
        TierPrice::create([
            'currency' => 'brl',
            'period' => PricingPeriod::Yearly,
            'cost' => 399.90,
            'tier_id' => $tier->id,
            'stripe_id' => config('subscription.wyvern.brl.yearly'),
        ]);

        return $this;
    }

    protected function elemental(): self
    {
        /** @var Tier $tier */
        $tier = Tier::where('name', 'Elemental')->first();
        foreach (['eur', 'usd'] as $currency) {
            TierPrice::create([
                'currency' => $currency,
                'period' => PricingPeriod::Monthly,
                'cost' => 24.99,
                'tier_id' => $tier->id,
                'stripe_id' => config('subscription.elemental.' . $currency . '.monthly'),
            ]);
            TierPrice::create([
                'currency' => $currency,
                'period' => PricingPeriod::Yearly,
                'cost' => 249.90,
                'tier_id' => $tier->id,
                'stripe_id' => config('subscription.elemental.' . $currency . '.yearly'),
            ]);
        }
        TierPrice::create([
            'currency' => 'brl',
            'period' => PricingPeriod::Monthly,
            'cost' => 99.99,
            'tier_id' => $tier->id,
            'stripe_id' => config('subscription.elemental.brl.monthly'),
        ]);
        TierPrice::create([
            'currency' => 'brl',
            'period' => PricingPeriod::Yearly,
            'cost' => 999.90,
            'tier_id' => $tier->id,
            'stripe_id' => config('subscription.elemental.brl.yearly'),
        ]);

        return $this;
    }
}
