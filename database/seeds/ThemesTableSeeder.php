<?php

use Illuminate\Database\Seeder;
use \App\Models\RpgSystem;

class ThemesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $themes = ['default', 'dark', 'future', 'midnight'];
        $created = 0;
        foreach ($themes as $theme) {
            $type = \App\Models\Theme::firstOrNew([
                'name' => $theme,
            ]);
            if (!$type->exists) {
                $type->fill([
                    'name' => $theme,
                ])->save();
                $created++;
            }
        }
    }
}
