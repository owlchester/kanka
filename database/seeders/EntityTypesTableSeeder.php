<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EntityTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = config('entities.ids');
        $position = 1;
        $created = 0;
        foreach ($types as $name => $id) {
            $type = \App\Models\EntityType::firstOrNew([
                'id' => $id,
            ]);
            if (! $type->exists) {
                $type->fill([
                    'code' => $name,
                    'is_enabled' => true,
                    'is_special' => false,
                    'position' => $position,
                    'icon' => '',
                ])->save();
                $created++;
            }
            $position++;
        }

        // We don't know whiteboards in advance
        $types = ['whiteboards'];
        foreach ($types as $name => $id) {
            $type = \App\Models\EntityType::firstOrNew([
                'code' => $id,
            ]);
            if (! $type->exists) {
                $type->fill([
                    'code' => $name,
                    'is_enabled' => true,
                    'is_special' => false,
                    'position' => $position,
                    'icon' => '',
                ])->save();
                $created++;
            }
            $position++;
        }
    }
}
