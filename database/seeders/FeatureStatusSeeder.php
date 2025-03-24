<?php

namespace Database\Seeders;

use App\Models\FeatureStatus;
use Illuminate\Database\Seeder;

class FeatureStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stats = [
            'draft',
            'rejected',
            'approved',
            'later',
            'next',
            'now',
            'done',
        ];
        foreach ($stats as $stat) {
            $s = FeatureStatus::firstOrNew([
                'name' => $stat,
            ]);
            $s->save();
        }
    }
}
