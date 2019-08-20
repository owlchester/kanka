<?php

use Illuminate\Database\Seeder;
use \App\Models\RpgSystem;

class RpgSystemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $order = 0;
        $codes = [
            'dnd5',
        ];

        RpgSystem::getQuery()->delete();

        foreach ($codes as $code) {
            $system = RpgSystem::firstOrNew(['code' => $code]);
            $system->fill([
                'code' => $code,
                'sort_order' => $order
            ])->save();
            $order++;
        }
    }
}
