<?php

use Illuminate\Database\Seeder;
use \App\Models\RpgSystem;

class EntityEventTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['primary', 'birth', 'death'];
        $created = 0;
        foreach ($types as $name) {
            $type = \App\Models\EntityEventType::firstOrNew([
                'name' => $name,
            ]);
            if (!$type->exists) {
                $type->fill([
                    'name' => $name,
                ])->save();
                $created++;
            }
        }
    }
}
