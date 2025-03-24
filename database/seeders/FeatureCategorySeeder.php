<?php

namespace Database\Seeders;

use App\Models\FeatureCategory;
use Illuminate\Database\Seeder;

class FeatureCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cats = [
            'Entities',
            'Search',
            'Layout',
            'Account',
            'Pricing',
            'Marketplace',
            'API',
            'Other',
        ];
        foreach ($cats as $cat) {
            $c = FeatureCategory::firstOrNew([
                'name' => $cat,
            ]);
            $c->save();
        }
    }
}
