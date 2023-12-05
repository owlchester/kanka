<?php

namespace Database\Seeders;

use App\Models\Pledge;
use App\Models\Tier;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class TierSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        Tier::truncate();
        $tier = Tier::firstOrNew(['name' => 'Kobold']);
        if (!$tier->exists) {
            $tier->fill([
                'code' => 'kobold',
                'name' => 'Kobold',
                'monthly' => 0,
                'yearly' => 0,
                'position' => 1,
            ])->save();
        }

        $tier = Tier::firstOrNew(['name' => 'Owlbear']);
        if (!$tier->exists) {
            $tier->fill([
                'code' => 'owlbear',
                'name' => 'Owlbear',
                'monthly' => 4.99,
                'yearly' => 49.90,
                'position' => 2,
            ])->save();
        }

        $tier = Tier::firstOrNew(['name' => 'Wyvern']);
        if (!$tier->exists) {
            $tier->fill([
                'code' => 'wyvern',
                'name' => 'Wyvern',
                'monthly' => 9.99,
                'yearly' => 99.90,
                'position' => 3,
            ])->save();
        }

        $tier = Tier::firstOrNew(['name' => 'Elemental']);
        if (!$tier->exists) {
            $tier->fill([
                'code' => 'elemental',
                'name' => 'Elemental',
                'monthly' => 24.99,
                'yearly' => 249.90,
                'position' => 4,
            ])->save();
        }
    }
}
