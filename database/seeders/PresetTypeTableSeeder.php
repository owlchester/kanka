<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PresetTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['marker'];
        $created = 0;
        foreach ($types as $name) {
            $type = \App\Models\PresetType::firstOrNew([
                'code' => $name,
            ]);
            if (! $type->exists) {
                $type->fill([
                    'code' => $name,
                ])->save();
                $created++;
            }
        }
    }
}
