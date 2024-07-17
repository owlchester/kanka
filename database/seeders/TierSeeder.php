<?php

namespace Database\Seeders;

use App\Models\Pledge;
use App\Models\Tier;
use Illuminate\Database\Seeder;

class TierSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $tier = Tier::firstOrNew(['name' => Pledge::KOBOLD]);
        if (!$tier->exists) {
            $tier->fill([
                'code' => 'kobold',
                'name' => Pledge::KOBOLD,
                'monthly' => 0,
                'yearly' => 0,
                'position' => 1,
            ])->save();
        }

        $tier = Tier::firstOrNew(['name' => Pledge::OWLBEAR]);
        if (!$tier->exists) {
            $tier->fill([
                'code' => 'owlbear',
                'name' => Pledge::OWLBEAR,
                'monthly' => 4.99,
                'yearly' => 49.90,
                'position' => 2,
            ])->save();
        }

        $tier = Tier::firstOrNew(['name' => Pledge::WYVERN]);
        if (!$tier->exists) {
            $tier->fill([
                'code' => 'wyvern',
                'name' => Pledge::WYVERN,
                'monthly' => 9.99,
                'yearly' => 99.90,
                'position' => 3,
            ])->save();
        }

        $tier = Tier::firstOrNew(['name' => Pledge::ELEMENTAL]);
        if (!$tier->exists) {
            $tier->fill([
                'code' => 'elemental',
                'name' => Pledge::ELEMENTAL,
                'monthly' => 24.99,
                'yearly' => 249.90,
                'position' => 4,
            ])->save();
        }
    }
}
