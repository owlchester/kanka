<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EntityEventTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['primary', 'birth', 'death', 'calendar_date', 'founded'];
        $created = 0;
        foreach ($types as $name) {
            $type = \App\Models\EntityEventType::firstOrNew([
                'name' => $name,
            ]);
            if (! $type->exists) {
                $type->fill([
                    'name' => $name,
                ])->save();
                $created++;
            }
        }
    }
}
